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

    // Drop existing tables if they exist (in correct order due to foreign keys)
    $conn->query("DROP TABLE IF EXISTS order_itemsUser");
    $conn->query("DROP TABLE IF EXISTS ordersUser");

    // Create ordersUser table
    $sql = "CREATE TABLE ordersUser (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_email VARCHAR(255) NOT NULL,
        customer_name VARCHAR(255) NOT NULL,
        address TEXT NOT NULL,
        phone VARCHAR(20) NOT NULL,
        social_media VARCHAR(255),
        total_price DECIMAL(10,2) NOT NULL,
        discount DECIMAL(10,2) NOT NULL,
        final_price DECIMAL(10,2) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating ordersUser table: " . $conn->error);
    }

    // Create order_itemsUser table
    $sql = "CREATE TABLE order_itemsUser (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        quantity INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES ordersUser(id) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating order_itemsUser table: " . $conn->error);
    }

    echo "Tables created successfully!";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 