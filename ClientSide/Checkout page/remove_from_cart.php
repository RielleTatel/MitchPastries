[file name]: remove_from_cart.php
[file content begin]
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
$user_email = $_SESSION['email'] ?? '';

if ($id && $user_email) {
  $stmt = $conn->prepare("DELETE FROM cartUser WHERE id = ? AND user_email = ?");
  $stmt->bind_param("is", $id, $user_email);
  
  if ($stmt->execute()) {
    echo "Item removed from cart";
  } else {
    echo "Error removing item";
  }
  
  $stmt->close();
} else {
  echo "Invalid request";
}

$conn->close();
?>
[file content end]