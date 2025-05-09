<?php
$conn = new mysqli("localhost", "root", "", "user");
$id = $_GET["id"] ?? 0;

$data = [];
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
}
echo json_encode($data);
$conn->close();
?>
