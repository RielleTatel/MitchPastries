<?php
session_start();
$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

// Connect to DB
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$product_id = $_POST['product_id'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$price = $_POST['price'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;
$user_email = $_SESSION['email'] ?? '';

if ($product_id && $product_name && $price && $user_email) {
  // Calculate total price
  $total_price = $price * $quantity;
  
  $stmt = $conn->prepare("INSERT INTO cartUser (product_id, product_name, price, quantity, user_email, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
  $stmt->bind_param("isdss", $product_id, $product_name, $total_price, $quantity, $user_email);

  if ($stmt->execute()) {
    echo "Successfully added to cart!";
  } else {
    echo "Database error: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "Please log in to add items to cart!";
}

$conn->close();
?>