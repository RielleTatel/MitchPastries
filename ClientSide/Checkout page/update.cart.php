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

$id = $_POST['id'] ?? 0;
$quantity = $_POST['quantity'] ?? 0;
$user_email = $_SESSION['email'] ?? '';

if ($id && $quantity > 0 && $user_email) {
  $stmt = $conn->prepare("UPDATE cartUser SET quantity = ? WHERE id = ? AND user_email = ?");
  $stmt->bind_param("iis", $quantity, $id, $user_email);
  
  if ($stmt->execute()) {
    echo "Cart updated successfully";
  } else {
    echo "Error updating cart";
  }
  
  $stmt->close();
} else {
  echo "Invalid request";
}

$conn->close();
?>