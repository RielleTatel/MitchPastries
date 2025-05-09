<?php
$conn = new mysqli("localhost", "root", "", "user");
$id = $_GET["id"] ?? 0;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
$conn->close();
?>
