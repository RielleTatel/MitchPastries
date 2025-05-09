<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create completed_orders table
$sql = "CREATE TABLE IF NOT EXISTS completed_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    social_media VARCHAR(255),
    total_price DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) NOT NULL,
    final_price DECIMAL(10,2) NOT NULL,
    created_at DATETIME NOT NULL,
    completed_at DATETIME NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table completed_orders created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?> 