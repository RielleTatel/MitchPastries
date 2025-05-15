<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Fetch active orders (removed status filter temporarily)
    $stmt = $conn->prepare("
        SELECT id, user_email, customer_name, address, phone, social_media, 
               total_price, discount, final_price, status, created_at 
        FROM ordersUser 
        ORDER BY created_at DESC
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed for active orders: " . $conn->error);
    }
    if (!$stmt->execute()) {
        throw new Exception("Error fetching active orders: " . $stmt->error);
    }
    $active_orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    error_log("Active orders count: " . count($active_orders));
    error_log("Active orders data: " . json_encode($active_orders));

    // Fetch completed orders from completed_orders table
    $stmt = $conn->prepare("
        SELECT id, order_id, customer_name, address, phone, social_media, 
               total_price, discount, final_price, status, created_at, completed_at 
        FROM completed_orders 
        ORDER BY completed_at DESC
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed for completed orders: " . $conn->error);
    }
    if (!$stmt->execute()) {
        throw new Exception("Error fetching completed orders: " . $stmt->error);
    }
    $completed_orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    error_log("Completed orders count: " . count($completed_orders));
    error_log("Completed orders data: " . json_encode($completed_orders));

    $response = [
        'active_orders' => $active_orders,
        'completed_orders' => $completed_orders
    ];
    error_log("Response data: " . json_encode($response));
    echo json_encode($response);

} catch (Exception $e) {
    error_log("Error in fetch_orders.php: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($stmt) && $stmt instanceof mysqli_stmt) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?> 