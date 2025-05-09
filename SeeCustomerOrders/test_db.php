<?php
$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Test orders table
    $result = $conn->query("SELECT COUNT(*) as count FROM orders");
    $row = $result->fetch_assoc();
    echo "Orders count: " . $row['count'] . "<br>";
    
    // Test order_items table
    $result = $conn->query("SELECT COUNT(*) as count FROM order_items");
    $row = $result->fetch_assoc();
    echo "Order items count: " . $row['count'] . "<br>";
    
    // Test if status column exists
    $result = $conn->query("SHOW COLUMNS FROM orders LIKE 'status'");
    echo "Status column exists: " . ($result->num_rows > 0 ? "Yes" : "No") . "<br>";
    
    // Test the actual query
    $sql = "SELECT o.id, o.customer_name, o.address, o.phone as contact, 
                   IFNULL(o.status, 'Pending') as status, o.created_at as date,
                   o.final_price as total_price
            FROM orders o
            LEFT JOIN order_items oi ON o.id = oi.order_id
            GROUP BY o.id";
    $result = $conn->query($sql);
    
    echo "Orders found: " . $result->num_rows . "<br>";
    echo "<pre>";
    print_r($result->fetch_all(MYSQLI_ASSOC));
    echo "</pre>";

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>