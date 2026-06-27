<?php
require_once("config/db.php");

// Admin details
$username = "admin";
$password = "HoLy-343";

// Check if admin already exists
$check = $conn->prepare("SELECT id FROM admins WHERE username = ?");
$check->execute([$username]);

if ($check->rowCount() > 0) {
    die("Admin account already exists.");
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert admin
$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashedPassword]);

echo "<h2>✅ Admin account created successfully!</h2>";
echo "<p><strong>Username:</strong> admin</p>";
echo "<p><strong>Password:</strong> HoLy-343</p>";
echo "<p><strong>IMPORTANT:</strong> Delete <code>setup_admin.php</code> immediately after this message appears.</p>";
?>
