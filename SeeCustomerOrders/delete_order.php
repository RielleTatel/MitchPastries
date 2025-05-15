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

    // Delete from ordersUser table
    $stmt = $conn->prepare("DELETE FROM ordersUser WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Order ID $order_id not found in ordersUser");
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 