[file name]: remove_from_cart.php
[file content begin]
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

$id = $_POST['id'] ?? '';

if ($id) {
  $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    echo "Item removed successfully";
  } else {
    echo "Error removing item: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "Invalid input!";
}

$conn->close();
?>
[file content end]