<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

try {
    // Connect to DB
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get customer info
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $cellphone = $_POST['cellphone'] ?? '';
    $socialmedia = $_POST['socialmedia'] ?? '';

    // Get cart items
    $cartItems = [];
    $cartResult = $conn->query("SELECT * FROM cart");
    if ($cartResult->num_rows > 0) {
        while($row = $cartResult->fetch_assoc()) {
            $cartItems[] = $row;
        }
    }

    if (empty($cartItems)) {
        throw new Exception("Error: Cart is empty");
    }

    // Calculate totals
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }
    $discount = $totalPrice * 0.05;
    $finalPrice = $totalPrice - $discount;

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert order
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, address, phone, social_media, total_price, discount, final_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssddd", $name, $address, $cellphone, $socialmedia, $totalPrice, $discount, $finalPrice);

        if (!$stmt->execute()) {
            throw new Exception("Error creating order: " . $stmt->error);
        }

        $orderId = $stmt->insert_id;
        
        // Insert order items
        foreach ($cartItems as $item) {
            $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
            $itemStmt->bind_param("iisdi", $orderId, $item['product_id'], $item['product_name'], $item['price'], $item['quantity']);
            if (!$itemStmt->execute()) {
                throw new Exception("Error adding order items: " . $itemStmt->error);
            }
            $itemStmt->close();
        }
        
        // Clear cart
        if (!$conn->query("DELETE FROM cart")) {
            throw new Exception("Error clearing cart: " . $conn->error);
        }

        // Commit transaction
        $conn->commit();
        
        // Send success response
        echo json_encode([
            'success' => true,
            'message' => 'Order placed successfully! Thank you for your order.'
        ]);
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
    // Send error response
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit();
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
[file content end]