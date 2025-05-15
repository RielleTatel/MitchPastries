<?php
$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
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
        status VARCHAR(20) NOT NULL DEFAULT 'Complete',
        created_at TIMESTAMP NOT NULL,
        completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating completed_orders table: " . $conn->error);
    }

    // Modify ordersUser table to ensure status column is VARCHAR(20)
    $sql = "ALTER TABLE ordersUser MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'Pending'";
    if (!$conn->query($sql)) {
        throw new Exception("Error modifying ordersUser table: " . $conn->error);
    }

    echo "Tables created/modified successfully!";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 