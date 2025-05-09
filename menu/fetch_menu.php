<?php
$conn = new mysqli("localhost", "root", "", "user");
$result = $conn->query("SELECT * FROM menu_items");

while ($row = $result->fetch_assoc()) {
    $image = htmlspecialchars($row["image"]);
    $name = htmlspecialchars($row["name"]);
    $price = number_format($row["price"], 2);
    $desc = htmlspecialchars($row["description"]);
    $category = htmlspecialchars($row["category"]);

    echo "<tr>
        <td><img src='uploads/{$image}' width='60'></td>
        <td>{$name}</td>
        <td>₱{$price}</td>
        <td>{$category}</td>
        <td class='description'>{$desc}</td>
        <td>
            <svg onclick='editProduct({$row["id"]})' style='cursor:pointer; margin-right:8px;' xmlns='http://www.w3.org/2000/svg' width='20' fill='#f90' viewBox='0 0 24 24'><path d='M5 20h14v2H5zm14.7-13.3a1 1 0 0 0 0-1.4l-2-2a1 1 0 0 0-1.4 0L14 5.6 18.4 10l1.3-1.3zM13.4 6.6L4 16v4h4l9.4-9.4-4-4z'/></svg>
            <svg onclick='deleteProduct({$row["id"]})' style='cursor:pointer' xmlns='http://www.w3.org/2000/svg' width='20' fill='red' viewBox='0 0 24 24'><path d='M3 6h18M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2m2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z'/></svg>
        </td>
    </tr>";
}
$conn->close();
?>
