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

    // Start transaction
    $conn->begin_transaction();

    try {
        // First, drop the existing foreign key constraint
        $sql = "ALTER TABLE completed_orders DROP FOREIGN KEY completed_orders_ibfk_1";
        if (!$conn->query($sql)) {
            throw new Exception("Failed to drop foreign key: " . $conn->error);
        }

        // Add the new foreign key constraint with ON DELETE SET NULL
        $sql = "ALTER TABLE completed_orders ADD CONSTRAINT completed_orders_ibfk_1 
                FOREIGN KEY (order_id) REFERENCES Orders(id) ON DELETE SET NULL";
        if (!$conn->query($sql)) {
            throw new Exception("Failed to add new foreign key: " . $conn->error);
        }

        // Commit transaction
        $conn->commit();
        echo "Successfully updated foreign key constraints";
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        throw $e;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 