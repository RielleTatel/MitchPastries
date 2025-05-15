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

    $order_id = $_POST['order_id'] ?? $_POST['id'] ?? null;
    if (!$order_id) {
        throw new Exception("Order ID is required");
    }

    // Try to delete from ordersUser first
    $stmt = $conn->prepare("DELETE FROM ordersUser WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $deleted_from_ordersUser = $stmt->affected_rows > 0;
    $stmt->close();

    if ($deleted_from_ordersUser) {
        echo json_encode(['success' => true]);
        $conn->close();
        exit;
    }

    // If not found, try to delete from completed_orders (by id or order_id)
    $stmt = $conn->prepare("DELETE FROM completed_orders WHERE id = ? OR order_id = ?");
    $stmt->bind_param("ii", $order_id, $order_id);
    $stmt->execute();
    $deleted_from_completed = $stmt->affected_rows > 0;
    $stmt->close();

    if ($deleted_from_completed) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Order ID $order_id not found in ordersUser or completed_orders");
    }

    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 