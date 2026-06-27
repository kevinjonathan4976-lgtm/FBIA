<?php
session_start();
require_once("../config/db.php");

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM admins WHERE username=?");
$stmt->execute([$username]);

$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if($admin && password_verify($password,$admin['password'])){

    $_SESSION['admin']=$admin['username'];

    header("Location: dashboard.php");

}else{

    echo "Invalid Username or Password";

}
?>
