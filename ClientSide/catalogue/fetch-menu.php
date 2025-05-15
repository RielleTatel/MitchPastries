<?php
$servername = "localhost";
$username = "root";
$password = ""; // adjust if needed
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM menu_items ORDER BY category";
$result = $conn->query($sql);

$menu = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Normalize category
        $category = strtolower(trim($row["category"]));

        // Set the image path to use the uploaded image if it exists
        if (!empty($row["image"])) {
            $row["image"] = "../../menu/uploads/" . $row["image"];
        } else {
            // Fallback to a default image if no image is uploaded
            $row["image"] = "../../images/default-pastry.jpg";
        }

        if (!isset($menu[$category])) {
            $menu[$category] = [];
        }
        $menu[$category][] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($menu);

$conn->close();
?>
