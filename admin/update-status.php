<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $status = trim($_POST['status']);
    $comment = trim($_POST['comment']);

    $allowedStatus = [
        "Received",
        "Under Investigation",
        "Resolved",
        "Closed"
    ];

    if (!in_array($status, $allowedStatus)) {
        die("Invalid status selected.");
    }

    $stmt = $conn->prepare("
        UPDATE reports
        SET status = ?, officer_comment = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $status,
        $comment,
        $id
    ]);

    header("Location: view-report.php?id=" . $id);
    exit();
}

header("Location: reports.php");
exit();
?>
