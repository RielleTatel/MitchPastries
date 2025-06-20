<?php
// Prevent any output before JSON response
ob_start();

// Set headers
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Start session
session_start();

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Function to log errors
function logError($message) {
    $logFile = __DIR__ . '/order_errors.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    
    // Ensure the log file exists and is writable
    if (!file_exists($logFile)) {
        touch($logFile);
        chmod($logFile, 0666);
    }
    
    // Log the error
    error_log($logMessage, 3, $logFile);
    
    // Also log to PHP error log for debugging
    error_log("[Order Submission] $message");
}

// Function to send JSON response
function sendJsonResponse($success, $message) {
    ob_end_clean();
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit();
}

// Log the start of the script
logError("Script started");

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    logError("User not logged in");
    sendJsonResponse(false, 'Please log in to place an order');
}

// Log session data
logError("Session data: " . print_r($_SESSION, true));
logError("POST data: " . print_r($_POST, true));

$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

try {
    // Connect to DB
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        logError("Database connection failed: " . $conn->connect_error);
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    logError("Database connection successful");

    // Get customer info
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $cellphone = $_POST['cellphone'] ?? '';
    $socialmedia = $_POST['socialmedia'] ?? '';
    $user_email = $_SESSION['email'] ?? '';

    logError("Processing order for user: $user_email");
    logError("Form data - Name: $name, Address: $address, Phone: $cellphone");

    if (empty($name) || empty($address) || empty($cellphone)) {
        logError("Missing required fields");
        throw new Exception("Please fill in all required fields");
    }

    // Get cart items for this user only
    $cartItems = [];
    $stmt = $conn->prepare("SELECT * FROM cartUser WHERE user_email = ?");
    if (!$stmt) {
        logError("Prepare failed for cart items: " . $conn->error);
        throw new Exception("Prepare failed for cart items: " . $conn->error);
    }

    $stmt->bind_param("s", $user_email);
    if (!$stmt->execute()) {
        logError("Failed to get cart items: " . $stmt->error);
        throw new Exception("Failed to get cart items: " . $stmt->error);
    }

    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }

    logError("Cart items found: " . print_r($cartItems, true));

    if (empty($cartItems)) {
        logError("Cart is empty for user: $user_email");
        throw new Exception("Error: Cart is empty");
    }

    logError("Found " . count($cartItems) . " items in cart");

    // Calculate totals
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }
    $discount = $totalPrice * 0.05;
    $finalPrice = $totalPrice - $discount;

    logError("Calculated totals - Total: $totalPrice, Discount: $discount, Final: $finalPrice");

    // Start transaction
    $conn->begin_transaction();
    logError("Transaction started");

    try {
        // Insert order
        $stmt = $conn->prepare("INSERT INTO ordersUser (user_email, customer_name, address, phone, social_media, total_price, discount, final_price, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        if (!$stmt) {
            logError("Prepare failed for order insert: " . $conn->error);
            throw new Exception("Prepare failed for order insert: " . $conn->error);
        }

        $stmt->bind_param("sssssddd", $user_email, $name, $address, $cellphone, $socialmedia, $totalPrice, $discount, $finalPrice);

        if (!$stmt->execute()) {
            logError("Error creating order: " . $stmt->error);
            throw new Exception("Error creating order: " . $stmt->error);
        }

        $orderId = $conn->insert_id;
        logError("Created order with ID: $orderId");
        
        // Insert order items
        $stmt = $conn->prepare("INSERT INTO order_itemsUser (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            logError("Prepare failed for order items: " . $conn->error);
            throw new Exception("Prepare failed for order items: " . $conn->error);
        }

        foreach ($cartItems as $item) {
            $product_id = (string)$item['product_id'];
            $stmt->bind_param("issdi", $orderId, $product_id, $item['product_name'], $item['price'], $item['quantity']);
            if (!$stmt->execute()) {
                logError("Error adding order item: " . $stmt->error);
                throw new Exception("Error adding order items: " . $stmt->error);
            }
        }
        
        // Clear only this user's cart
        $stmt = $conn->prepare("DELETE FROM cartUser WHERE user_email = ?");
        if (!$stmt) {
            logError("Prepare failed for cart clear: " . $conn->error);
            throw new Exception("Prepare failed for cart clear: " . $conn->error);
        }

        $stmt->bind_param("s", $user_email);
        if (!$stmt->execute()) {
            logError("Error clearing cart: " . $stmt->error);
            throw new Exception("Error clearing cart: " . $stmt->error);
        }

        // Commit transaction
        $conn->commit();
        logError("Order completed successfully");
        
        // Send success response
        sendJsonResponse(true, 'Order placed successfully! Thank you for your order.');

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        logError("Transaction rolled back: " . $e->getMessage());
        throw $e;
    }

} catch (Exception $e) {
    // Send error response
    logError("Error in order submission: " . $e->getMessage());
    sendJsonResponse(false, $e->getMessage());
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
    logError("Script completed");
}
?>
[file content end]