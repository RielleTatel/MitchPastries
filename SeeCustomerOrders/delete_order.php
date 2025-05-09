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

    // Get the order ID from POST data
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    
    if ($orderId <= 0) {
        throw new Exception("Invalid order ID: " . $orderId);
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // First check if the order exists in orders table
        $checkOrder = $conn->prepare("SELECT id FROM orders WHERE id = ?");
        if (!$checkOrder) {
            throw new Exception("Failed to prepare check order statement: " . $conn->error);
        }
        $checkOrder->bind_param("i", $orderId);
        $checkOrder->execute();
        $result = $checkOrder->get_result();
        
        if ($result->num_rows > 0) {
            // Delete from order_items first
            $deleteItems = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
            if (!$deleteItems) {
                throw new Exception("Failed to prepare delete items statement: " . $conn->error);
            }
            $deleteItems->bind_param("i", $orderId);
            $deleteItems->execute();

            // Then delete from orders table
            $deleteOrder = $conn->prepare("DELETE FROM orders WHERE id = ?");
            if (!$deleteOrder) {
                throw new Exception("Failed to prepare delete order statement: " . $conn->error);
            }
            $deleteOrder->bind_param("i", $orderId);
            
            if (!$deleteOrder->execute()) {
                throw new Exception("Failed to execute delete: " . $deleteOrder->error);
            }

            if ($deleteOrder->affected_rows === 0) {
                throw new Exception("Failed to delete order from orders table");
            }
        } else {
            // Check completed_orders table
            $checkCompleted = $conn->prepare("SELECT id FROM completed_orders WHERE id = ?");
            if (!$checkCompleted) {
                throw new Exception("Failed to prepare check completed order statement: " . $conn->error);
            }
            $checkCompleted->bind_param("i", $orderId);
            $checkCompleted->execute();
            $completedResult = $checkCompleted->get_result();
            
            if ($completedResult->num_rows > 0) {
                // Order exists in completed_orders table
                $deleteCompleted = $conn->prepare("DELETE FROM completed_orders WHERE id = ?");
                if (!$deleteCompleted) {
                    throw new Exception("Failed to prepare delete completed order statement: " . $conn->error);
                }
                $deleteCompleted->bind_param("i", $orderId);
                $deleteCompleted->execute();
            } else {
                throw new Exception("Order ID " . $orderId . " not found in either active or completed orders");
            }
        }

        // Commit transaction
        $conn->commit();
        
        echo json_encode(['success' => true, 'message' => 'Order deleted successfully']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        throw $e;
    }
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($checkOrder)) {
        $checkOrder->close();
    }
    if (isset($deleteItems)) {
        $deleteItems->close();
    }
    if (isset($deleteOrder)) {
        $deleteOrder->close();
    }
    if (isset($checkCompleted)) {
        $checkCompleted->close();
    }
    if (isset($deleteCompleted)) {
        $deleteCompleted->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?> 