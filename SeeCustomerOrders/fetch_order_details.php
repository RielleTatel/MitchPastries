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

    $order_id = $_GET['id'] ?? 0;
    if (!$order_id) {
        throw new Exception("Order ID is required");
    }

    // Try to fetch from ordersUser first
    $stmt = $conn->prepare("
        SELECT id, user_email, customer_name, address, phone, social_media, 
               total_price, discount, final_price, status, created_at 
        FROM ordersUser 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    // If not found, try completed_orders
    if (!$order) {
        $stmt = $conn->prepare("
            SELECT id, order_id, customer_name, address, phone, social_media, 
                   total_price, discount, final_price, status, created_at, completed_at 
            FROM completed_orders 
            WHERE id = ? OR order_id = ?
        ");
        $stmt->bind_param("ii", $order_id, $order_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        // For completed orders, set user_email to null if not present
        if ($order && !isset($order['user_email'])) {
            $order['user_email'] = null;
        }
    }

    if (!$order) {
        throw new Exception("Order not found");
    }

    // Fetch order items (always use order_id for completed orders)
    $order_items_id = isset($order['order_id']) ? $order['order_id'] : $order['id'];
    $stmt = $conn->prepare("
        SELECT id, product_id, product_name, price, quantity, created_at 
        FROM order_itemsUser 
        WHERE order_id = ?
    ");
    $stmt->bind_param("i", $order_items_id);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $order['items'] = $items;

    echo json_encode($order);

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