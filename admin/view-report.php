<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once("../config/db.php");

if (!isset($_GET['id'])) {
    die("No report selected.");
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM reports WHERE id = ?");
$stmt->execute([$id]);

$report = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$report) {
    die("Report not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Report</title>

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
    width:90%;
    max-width:900px;
    margin:30px auto;
}

.card{
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

p{
    margin:12px 0;
}

label{
    display:block;
    margin-top:15px;
    font-weight:bold;
}

select,
textarea{
    width:100%;
    padding:12px;
    margin-top:8px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    margin-top:20px;
    padding:12px 25px;
    background:#002147;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#004080;
}

img{
    max-width:300px;
    margin-top:15px;
    border-radius:8px;
}
</style>

</head>

<body>

<header>
<h1>FBIA Report Details</h1>
</header>

<div class="container">

<div class="card">

<h2><?php echo htmlspecialchars($report['report_id']); ?></h2>

<p><strong>Name:</strong>
<?php
echo $report['anonymous']
? "Anonymous"
: htmlspecialchars($report['fullname']);
?>
</p>

<p><strong>Email:</strong>
<?php echo htmlspecialchars($report['email']); ?>
</p>

<p><strong>Phone:</strong>
<?php echo htmlspecialchars($report['phone']); ?>
</p>

<p><strong>Category:</strong>
<?php echo htmlspecialchars($report['category']); ?>
</p>

<p><strong>Location:</strong>
<?php echo htmlspecialchars($report['location']); ?>
</p>

<p><strong>Date:</strong>
<?php echo htmlspecialchars($report['incident_date']); ?>
</p>

<p><strong>Time:</strong>
<?php echo htmlspecialchars($report['incident_time']); ?>
</p>

<p><strong>Description:</strong></p>

<p>
<?php echo nl2br(htmlspecialchars($report['description'])); ?>
</p>

<?php if(!empty($report['evidence'])){ ?>

<p><strong>Evidence:</strong></p>

<img src="../uploads/<?php echo htmlspecialchars($report['evidence']); ?>">

<?php } ?>

<hr>

<form action="update-status.php" method="POST">

<input
type="hidden"
name="id"
value="<?php echo $report['id']; ?>">

<label>Status</label>

<select name="status">

<option <?php if($report['status']=="Received") echo "selected"; ?>>
Received
</option>

<option <?php if($report['status']=="Under Investigation") echo "selected"; ?>>
Under Investigation
</option>

<option <?php if($report['status']=="Resolved") echo "selected"; ?>>
Resolved
</option>

<option <?php if($report['status']=="Closed") echo "selected"; ?>>
Closed
</option>

</select>

<label>Officer Comment</label>

<textarea
name="comment"
rows="6"><?php echo htmlspecialchars($report['officer_comment']); ?></textarea>

<button type="submit">
Update Report
</button>

</form>

</div>

</div>

</body>
</html>
