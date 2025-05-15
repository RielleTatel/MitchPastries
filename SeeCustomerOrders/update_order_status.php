<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    error_log("Unauthorized access attempt");
    echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
    exit;
}

// Get JSON data from request body
$data = json_decode(file_get_contents('php://input'), true);
error_log("Received data: " . json_encode($data));

if (!isset($data['order_id']) || !isset($data['status'])) {
    error_log("Missing parameters: " . json_encode($data));
    echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
    exit;
}

$order_id = $data['order_id'];
$status = $data['status'];

$valid_statuses = ['Pending', 'In Progress', 'Complete'];
if (!in_array($status, $valid_statuses)) {
    error_log("Invalid status: " . $status);
    echo json_encode(['success' => false, 'error' => 'Invalid status']);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'user');
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

try {
    if ($status === 'Complete') {
        error_log("Processing Complete status for order: " . $order_id);
        
        // Start transaction
        $conn->begin_transaction();

        // Get the order data
        $stmt = $conn->prepare("SELECT * FROM ordersUser WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        
        if (!$order) {
            error_log("Order not found: " . $order_id);
            throw new Exception('Order not found');
        }

        error_log("Found order data: " . json_encode($order));

        // Insert into completed_orders
        $stmt = $conn->prepare("INSERT INTO completed_orders (
            order_id, customer_name, address, phone, social_media, total_price, discount, final_price, created_at, status, completed_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $status = 'Complete';
        $stmt->bind_param(
            "issssdddss",
            $order['id'],
            $order['customer_name'],
            $order['address'],
            $order['phone'],
            $order['social_media'],
            $order['total_price'],
            $order['discount'],
            $order['final_price'],
            $order['created_at'],
            $status
        );
        
        if (!$stmt->execute()) {
            error_log("Failed to insert into completed_orders: " . $stmt->error);
            throw new Exception('Failed to insert into completed_orders: ' . $stmt->error);
        }

        // Delete from ordersUser
        $stmt = $conn->prepare("DELETE FROM ordersUser WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        if (!$stmt->execute()) {
            error_log("Failed to delete from ordersUser: " . $stmt->error);
            throw new Exception('Failed to delete from ordersUser: ' . $stmt->error);
        }

        // Commit transaction
        $conn->commit();
        error_log("Successfully completed order: " . $order_id);
        echo json_encode(['success' => true]);
    } else {
        error_log("Updating status to " . $status . " for order: " . $order_id);
        
        // Just update the status
        $stmt = $conn->prepare("UPDATE ordersUser SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $order_id);
        
        if (!$stmt->execute()) {
            error_log("Failed to update order status: " . $stmt->error);
            throw new Exception('Failed to update order status: ' . $stmt->error);
        }
        
        if ($stmt->affected_rows > 0) {
            error_log("Successfully updated status for order: " . $order_id);
            echo json_encode(['success' => true]);
        } else {
            error_log("No rows updated for order: " . $order_id);
            echo json_encode([
                'success' => false,
                'error' => 'No rows updated. Status: ' . $status . ', Order ID: ' . $order_id
            ]);
        }
    }
} catch (Exception $e) {
    error_log("Error in update_order_status.php: " . $e->getMessage());
    // Rollback transaction if it was started
    if (isset($conn)) {
        $conn->rollback();
    }
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>