<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

require_once("../config/db.php");

$stmt = $conn->query("SELECT * FROM reports ORDER BY created_at DESC");
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crime Reports</title>

<style>

body{
    margin:0;
    font-family:Arial,Helvetica,sans-serif;
    background:#f4f4f4;
}

header{
    background:#002147;
    color:#fff;
    padding:20px;
}

.container{
    width:95%;
    margin:30px auto;
}

h2{
    color:#002147;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
}

table th,
table td{
    padding:12px;
    border:1px solid #ddd;
    text-align:left;
}

table th{
    background:#002147;
    color:#fff;
}

tr:nth-child(even){
    background:#f9f9f9;
}

.btn{
    text-decoration:none;
    color:#fff;
    background:#002147;
    padding:8px 12px;
    border-radius:5px;
}

.btn:hover{
    background:#004080;
}

.logout{
    float:right;
    color:white;
    text-decoration:none;
}

.status{
    font-weight:bold;
}

</style>

</head>

<body>

<header>

<h1>
FBIA Admin Dashboard
</h1>

<a class="logout" href="logout.php">
Logout
</a>

</header>

<div class="container">

<h2>Crime Reports</h2>

<table>

<tr>

<th>Report ID</th>

<th>Name</th>

<th>Category</th>

<th>Location</th>

<th>Status</th>

<th>Date</th>

<th>Action</th>

</tr>

<?php foreach($reports as $report){ ?>

<tr>

<td><?php echo htmlspecialchars($report['report_id']); ?></td>

<td>
<?php
echo $report['anonymous']
? "Anonymous"
: htmlspecialchars($report['fullname']);
?>
</td>

<td><?php echo htmlspecialchars($report['category']); ?></td>

<td><?php echo htmlspecialchars($report['location']); ?></td>

<td class="status">
<?php echo htmlspecialchars($report['status']); ?>
</td>

<td><?php echo htmlspecialchars($report['created_at']); ?></td>

<td>

<a class="btn"
href="view-report.php?id=<?php echo $report['id']; ?>">
View
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>
