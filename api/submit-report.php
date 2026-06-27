<?php
require_once("../config/db.php");

// Generate Report ID
$reportID = "FBIA-" . date("Y") . "-" . strtoupper(substr(md5(uniqid()), 0, 8));

// Get form data
$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$anonymous = isset($_POST['anonymous']) ? 1 : 0;
$category = $_POST['category'] ?? '';
$location = $_POST['location'] ?? '';
$incident_date = $_POST['incident_date'] ?? '';
$incident_time = $_POST['incident_time'] ?? '';
$description = $_POST['description'] ?? '';

// Handle file upload
$evidence = "";

if(isset($_FILES['evidence']) && $_FILES['evidence']['error'] == 0){

    $uploadDir = "../uploads/";

    if(!is_dir($uploadDir)){
        mkdir($uploadDir,0777,true);
    }

    $filename = time() . "_" . basename($_FILES["evidence"]["name"]);
    $targetFile = $uploadDir . $filename;

    move_uploaded_file($_FILES["evidence"]["tmp_name"], $targetFile);

    $evidence = $filename;
}

// Save report
$sql = "INSERT INTO reports
(report_id, fullname, email, phone, anonymous, category,
location, incident_date, incident_time, description, evidence)

VALUES
(?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $reportID,
    $fullname,
    $email,
    $phone,
    $anonymous,
    $category,
    $location,
    $incident_date,
    $incident_time,
    $description,
    $evidence
]);

?>

<!DOCTYPE html>
<html>
<head>
<title>Report Submitted</title>

<style>

body{
font-family:Arial;
background:#f4f4f4;
text-align:center;
padding:60px;
}

.card{

background:white;
padding:40px;
max-width:700px;
margin:auto;
border-radius:10px;
box-shadow:0 5px 20px rgba(0,0,0,.2);

}

h1{
color:green;
}

.report{
font-size:25px;
font-weight:bold;
color:#002147;
margin:20px 0;
}

a{

display:inline-block;
margin-top:20px;
padding:12px 25px;
background:#002147;
color:white;
text-decoration:none;
border-radius:5px;

}

</style>

</head>

<body>

<div class="card">

<h1>Report Submitted Successfully</h1>

<p>
Thank you for helping keep the community safe.
Your report has been received.
</p>

<p>Your Report ID is</p>

<div class="report">
<?php echo $reportID; ?>
</div>

<p>
Please save this Report ID. You'll need it to track the progress of your report.
</p>

<a href="../track.html">Track My Report</a>

</div>

</body>
</html>
