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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST["email"];
    $pass = $_POST["password"];

    $sql = $conn->prepare("SELECT u_password FROM registration WHERE u_email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();
        $hashed_pass = $row["u_password"];

        if (password_verify($pass, $hashed_pass)) {
            $_SESSION['email'] = $email;
            header("Location: ../homePage/index.html");
            exit;
        } else {
            header("Location: index.php?error=wrongpass");
            exit;   
        }
    } else {
        header("Location: index.php?error=nouser");
        exit;
    }

    $sql->close();
}

$conn->close();
?>