<?php
session_start();

if(isset($_SESSION['admin'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>FBIA Admin Login</title>

<style>
body{
    font-family:Arial,sans-serif;
    background:#002147;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    background:#fff;
    width:400px;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,.3);
}

h2{
    text-align:center;
    color:#002147;
}

input{
    width:100%;
    padding:12px;
    margin:12px 0;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    background:#002147;
    color:#fff;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#003b7a;
}
</style>

</head>

<body>

<div class="login-box">

<h2>FBIA Administrator Login</h2>

<form action="authenticate.php" method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit">
Login
</button>

</form>

</div>

</body>
</html>
