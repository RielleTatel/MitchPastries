<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $orderId = $_POST['order_id'] ?? '';
    $newStatus = $_POST['status'] ?? '';

    if (empty($orderId) || empty($newStatus)) {
        throw new Exception("Order ID and status are required");
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        if ($newStatus === 'Completed') {
            // First, get the order details
            $sql = "SELECT * FROM Orders WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            $order = $result->fetch_assoc();

            if (!$order) {
                throw new Exception("Order not found");
            }

            // Insert into completed_orders
            $sql = "INSERT INTO completed_orders (order_id, customer_name, address, phone, social_media, total_price, discount, final_price, created_at, completed_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssddds", 
                $order['id'],
                $order['customer_name'],
                $order['address'],
                $order['phone'],
                $order['social_media'],
                $order['total_price'],
                $order['discount'],
                $order['final_price'],
                $order['created_at']
            );
            $stmt->execute();

            // Delete from Orders table
            $sql = "DELETE FROM Orders WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();

        } else {
            // Update status in Orders table
            $sql = "UPDATE Orders SET status = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newStatus, $orderId);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {
                throw new Exception("No order was updated");
            }
        }

        // Commit transaction
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
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