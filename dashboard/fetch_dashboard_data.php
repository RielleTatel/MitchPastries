<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count active orders from Orders table
$sql = "SELECT COUNT(*) as total_orders FROM Orders";
$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data['total_orders'] = $row['total_orders'];
} else {
    $data['total_orders'] = 0;
}

// Get total income from completed orders
$sql = "SELECT SUM(final_price) as expected_income FROM completed_orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data['expected_income'] = number_format($row['expected_income'] ?? 0, 2);
} else {
    $data['expected_income'] = "0.00";
}

$sql = "SELECT 
            DATE(created_at) as date, 
            COUNT(*) as order_count, 
            SUM(final_price) as daily_revenue 
        FROM Orders 
        WHERE status = 'Completed'
        GROUP BY DATE(created_at) 
        ORDER BY date DESC 
        LIMIT 7";
$result = $conn->query($sql);

$data['recent_orders'] = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data['recent_orders'][] = array(
            'date' => $row['date'],
            'order_count' => $row['order_count'],
            'revenue' => $row['daily_revenue']
        );
    }
}

// Fetch top selling products
$sql = "SELECT 
            oi.product_name,
            SUM(oi.quantity) as total_quantity,
            SUM(oi.price * oi.quantity) as total_revenue
        FROM order_items oi
        JOIN Orders o ON oi.order_id = o.id
        WHERE o.status = 'Completed'
        GROUP BY oi.product_name
        ORDER BY total_quantity DESC
        LIMIT 5";
$result = $conn->query($sql);

$data['top_products'] = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data['top_products'][] = array(
            'product_name' => $row['product_name'],
            'total_quantity' => $row['total_quantity'],
            'total_revenue' => $row['total_revenue']
        );
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?> 