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

    // Check if ordersUser table exists
    $result = $conn->query("SHOW TABLES LIKE 'ordersUser'");
    if ($result->num_rows === 0) {
        throw new Exception("ordersUser table does not exist");
    }

    // Check if order_itemsUser table exists
    $result = $conn->query("SHOW TABLES LIKE 'order_itemsUser'");
    if ($result->num_rows === 0) {
        throw new Exception("order_itemsUser table does not exist");
    }

    // Get the current foreign key constraint
    $result = $conn->query("SELECT CONSTRAINT_NAME 
                           FROM information_schema.TABLE_CONSTRAINTS 
                           WHERE TABLE_SCHEMA = '$dbname' 
                           AND TABLE_NAME = 'order_itemsUser' 
                           AND CONSTRAINT_TYPE = 'FOREIGN KEY'");
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $constraint_name = $row['CONSTRAINT_NAME'];
        
        // Drop the existing foreign key
        $conn->query("ALTER TABLE order_itemsUser DROP FOREIGN KEY `$constraint_name`");
        echo "Dropped existing foreign key constraint: $constraint_name<br>";
    }

    // Add the correct foreign key constraint
    $conn->query("ALTER TABLE order_itemsUser 
                 ADD CONSTRAINT order_itemsuser_ibfk_1 
                 FOREIGN KEY (order_id) 
                 REFERENCES ordersUser(id) 
                 ON DELETE CASCADE");
    
    echo "Added new foreign key constraint successfully!";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 