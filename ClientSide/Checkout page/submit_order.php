<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Please log in to place an order']);
    exit;
}

// Database connection
$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Start transaction
    $conn->begin_transaction();

    // Get form data
    $user_email = $_SESSION['email'];
    $customer_name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['cellphone'] ?? '';
    $social_media = $_POST['socialmedia'] ?? '';

    // Validate required fields
    if (empty($customer_name) || empty($address) || empty($phone)) {
        throw new Exception("Please fill in all required fields");
    }

    // Get cart items
    $stmt = $conn->prepare("SELECT * FROM cartUser WHERE user_email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $cart_result = $stmt->get_result();
    
    if ($cart_result->num_rows === 0) {
        throw new Exception("Your cart is empty");
    }

    // Calculate totals
    $total_price = 0;
    $cart_items = [];
    while ($item = $cart_result->fetch_assoc()) {
        $total_price += ($item['price'] * $item['quantity']);
        $cart_items[] = $item;
    }
    $discount = $total_price * 0.05;
    $final_price = $total_price - $discount;

    // Insert into ordersUser table
    $stmt = $conn->prepare("INSERT INTO ordersUser (user_email, customer_name, address, phone, social_media, total_price, discount, final_price, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->bind_param("sssssddd", $user_email, $customer_name, $address, $phone, $social_media, $total_price, $discount, $final_price);
    
    if (!$stmt->execute()) {
        throw new Exception("Error creating order: " . $stmt->error);
    }

    $order_id = $conn->insert_id;

    // Insert into order_itemsUser table
    $stmt = $conn->prepare("INSERT INTO order_itemsUser (order_id, product_id, product_name, price, quantity, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    
    foreach ($cart_items as $item) {
        $stmt->bind_param("iisdi", $order_id, $item['product_id'], $item['product_name'], $item['price'], $item['quantity']);
        if (!$stmt->execute()) {
            throw new Exception("Error adding order items: " . $stmt->error);
        }
    }

    // Clear the user's cart
    $stmt = $conn->prepare("DELETE FROM cartUser WHERE user_email = ?");
    $stmt->bind_param("s", $user_email);
    if (!$stmt->execute()) {
        throw new Exception("Error clearing cart: " . $stmt->error);
    }

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully! Thank you for your order.',
        'order_id' => $order_id
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($conn)) {
        $conn->rollback();
    }
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?> 