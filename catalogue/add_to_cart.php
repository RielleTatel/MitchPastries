<?php
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

if ($product_id && $product_name && $price) {
  // Calculate total price
  $total_price = $price * $quantity;
  
  $stmt = $conn->prepare("INSERT INTO cart (product_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("isdi", $product_id, $product_name, $total_price, $quantity);

  if ($stmt->execute()) {
    echo "Successfully added to cart!";
  } else {
    echo "Database error: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "Invalid input!";
}

$conn->close();
?>