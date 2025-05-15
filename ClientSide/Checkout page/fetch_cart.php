<?php
session_start();
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

// Connect to DB
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_email = $_SESSION['email'] ?? '';

if ($user_email) {
    $stmt = $conn->prepare("SELECT id, product_id, product_name, price, quantity FROM cartUser WHERE user_email = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $user_email);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $items = array();
        
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        echo json_encode($items);
    } else {
        echo json_encode(array("error" => "Failed to fetch cart items"));
    }
    
    $stmt->close();
} else {
    echo json_encode(array("error" => "User not logged in"));
}

$conn->close();
?>