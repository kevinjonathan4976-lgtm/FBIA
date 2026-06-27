<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once("../config/db.php");

// Dashboard Statistics
$totalReports = $conn->query("SELECT COUNT(*) FROM reports")->fetchColumn();

$received = $conn->query("SELECT COUNT(*) FROM reports WHERE status='Received'")->fetchColumn();

$investigating = $conn->query("SELECT COUNT(*) FROM reports WHERE status='Under Investigation'")->fetchColumn();

$resolved = $conn->query("SELECT COUNT(*) FROM reports WHERE status='Resolved'")->fetchColumn();

$recentReports = $conn->query("SELECT * FROM reports ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FBIA Admin Dashboard</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,Helvetica,sans-serif;
}

body{
display:flex;
background:#eef2f7;
}

.sidebar{

width:250px;
height:100vh;
background:#002147;
color:white;
position:fixed;
padding-top:20px;

}

.sidebar h2{
text-align:center;
margin-bottom:30px;
}

.sidebar a{

display:block;
color:white;
text-decoration:none;
padding:15px 25px;
transition:.3s;

}

.sidebar a:hover{

background:#003b70;

}

.main{

margin-left:250px;
width:100%;
padding:30px;

}

.topbar{

background:white;
padding:20px;
border-radius:10px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 2px 10px rgba(0,0,0,.1);

}

.cards{

display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
margin-top:30px;

}

.card{

background:white;
padding:25px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,.1);

}

.card h3{

font-size:35px;
color:#002147;

}

.card p{

margin-top:10px;
font-size:18px;

}

table{

width:100%;
margin-top:30px;
border-collapse:collapse;
background:white;
border-radius:10px;
overflow:hidden;

}

table th{

background:#002147;
color:white;
padding:15px;

}

table td{

padding:15px;
border-bottom:1px solid #ddd;

}

.btn{

background:#002147;
color:white;
padding:8px 15px;
text-decoration:none;
border-radius:5px;

}

.btn:hover{

background:#004080;

}

</style>

</head>

<body>

<div class="sidebar">

<h2>FBIA</h2>

<a href="dashboard.php">
<i class="fa fa-home"></i>
Dashboard
</a>

<a href="reports.php">
<i class="fa fa-folder"></i>
Reports
</a>

<a href="../report.html">
<i class="fa fa-plus"></i>
New Report
</a>

<a href="logout.php">
<i class="fa fa-sign-out-alt"></i>
Logout
</a>

</div>

<div class="main">

<div class="topbar">

<h2>Administrator Dashboard</h2>

<p>
Welcome,
<strong><?php echo htmlspecialchars($_SESSION['admin']); ?></strong>
</p>

</div>

<div class="cards">

<div class="card">

<h3><?php echo $totalReports; ?></h3>

<p>Total Reports</p>

</div>

<div class="card">

<h3><?php echo $received; ?></h3>

<p>Received</p>

</div>

<div class="card">

<h3><?php echo $investigating; ?></h3>

<p>Under Investigation</p>

</div>

<div class="card">

<h3><?php echo $resolved; ?></h3>

<p>Resolved</p>

</div>

</div>

<h2 style="margin-top:40px;">
Recent Reports
</h2>

<table>

<tr>

<th>Report ID</th>

<th>Category</th>

<th>Status</th>

<th>Date</th>

<th>Action</th>

</tr>

<?php foreach($recentReports as $report){ ?>

<tr>

<td><?php echo htmlspecialchars($report['report_id']); ?></td>

<td><?php echo htmlspecialchars($report['category']); ?></td>

<td><?php echo htmlspecialchars($report['status']); ?></td>

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
