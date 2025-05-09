<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {

    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $confirmpass = $_POST["confirm_password"];

    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = $conn->prepare("INSERT INTO `registration`(`u_fullname`, `u_email`, `u_password`) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $fullname, $email, $hashed_pass);

    if ($sql->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql->error;
    }
    $sql->close();
}

$conn->close();
?>