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

    $orderId = $_GET['id'] ?? '';
    if (empty($orderId)) {
        throw new Exception("Order ID is required");
    }

    $sql = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement for Orders: " . $conn->error);
    }
    
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    // If not found in active orders, check in completed orders
    if (!$order) {
        $sql = "SELECT * FROM completed_orders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement for completed_orders: " . $conn->error);
        }
        
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
    }

    if (!$order) {
        throw new Exception("Order not found");
    }

    // Get order items
    $sql = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement for order_items: " . $conn->error);
    }
    
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = array();
    while ($row = $result->fetch_assoc()) {
        $items[] = array(
            'product_name' => $row['product_name'] ?? 'N/A',
            'price' => $row['price'] ?? 0,
            'quantity' => $row['quantity'] ?? 0
        );
    }
    
    // Ensure all required fields are present in the order
    $response = array(
        'id' => $order['id'],
        'customer_name' => $order['customer_name'] ?? 'N/A',
        'address' => $order['address'] ?? 'N/A',
        'phone' => $order['phone'] ?? 'N/A',
        'social_media' => $order['social_media'] ?? 'N/A',
        'status' => $order['status'] ?? 'Pending',
        'total_price' => $order['total_price'] ?? 0,
        'discount' => $order['discount'] ?? 0,
        'final_price' => $order['final_price'] ?? 0,
        'created_at' => $order['created_at'] ?? null,
        'completed_at' => $order['completed_at'] ?? null,
        'items' => $items
    );

    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?> 