<?php
$conn = new mysqli("localhost", "root", "", "user");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? "";
    $name = $_POST["name"];
    $price = $_POST["price"];
    $desc = $_POST["description"];
    $category = $_POST["category"];

    $imageName = "";
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                error_log("Failed to create uploads directory");
                die("Failed to create uploads directory");
            }
        }

        $imageName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;
        
        // Check for upload errors
        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            error_log("Upload error: " . $_FILES["image"]["error"]);
            die("Upload failed with error code: " . $_FILES["image"]["error"]);
        }
        
        // Try to move the uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            error_log("Failed to move uploaded file to: " . $targetFile);
            die("Failed to save the uploaded file");
        }
    }

    if ($id) {
        if ($imageName) {
            $stmt = $conn->prepare("UPDATE menu_items SET image=?, name=?, price=?, category=?, description=? WHERE id=?");
            $stmt->bind_param("ssdssi", $imageName, $name, $price, $category, $desc, $id);
        } else {
            $stmt = $conn->prepare("UPDATE menu_items SET name=?, price=?, category=?, description=? WHERE id=?");
            $stmt->bind_param("sdssi", $name, $price, $category, $desc, $id);
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO menu_items (image, name, price, category, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $imageName, $name, $price, $category, $desc);
    }

    $stmt->execute();
    $stmt->close();
}
$conn->close();
?>
