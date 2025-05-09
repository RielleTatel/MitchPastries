<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$dbname = "user";
$username = "root";
$password = "";

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Fetch active orders
    $sql = "SELECT * FROM orders ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $active_orders = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $active_orders[] = $row;
        }
    }

    // Fetch completed orders
    $sql = "SELECT * FROM completed_orders ORDER BY completed_at DESC";
    $result = $conn->query($sql);

    $completed_orders = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $completed_orders[] = $row;
        }
    }

    // Return both sets of orders
    $response = array(
        'active_orders' => $active_orders,
        'completed_orders' => $completed_orders
    );

    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>