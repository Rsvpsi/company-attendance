<?php
session_start();
include("db.php");

if (!isset($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

// Filter by date
$date = "";

if(isset($_POST['search']))
{
    $date = $_POST['attendance_date'];

    $sql = "SELECT attendance.*, employees.employee_name, employees.employee_code
            FROM attendance
            INNER JOIN employees
            ON attendance.employee_id = employees.employee_id
            WHERE attendance.attendance_date='$date'
            ORDER BY attendance.attendance_id DESC";
}
else
{
    $sql = "SELECT attendance.*, employees.employee_name, employees.employee_code
            FROM attendance
            INNER JOIN employees
            ON attendance.employee_id = employees.employee_id
            ORDER BY attendance.attendance_id DESC";
}

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Attendance Report</title>

<link rel="stylesheet" href="css/style.css">

<style>

.container{
    width:95%;
    margin:auto;
    margin-top:30px;
}

.search-box{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px gray;
}

input{
    padding:10px;
    width:250px;
}

button{
    background:#0d6efd;
    color:white;
    border:none;
    padding:10px 20px;
    cursor:pointer;
}

.print-btn{
    background:green;
}

table{
    width:100%;
    margin-top:25px;
    border-collapse:collapse;
}

table th{
    background:#0d6efd;
    color:white;
    padding:12px;
}

table td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

.present{
    color:green;
    font-weight:bold;
}

.absent{
    color:red;
    font-weight:bold;
}

.leave{
    color:orange;
    font-weight:bold;
}

.weekoff{
    color:blue;
    font-weight:bold;
}

.holiday{
    color:purple;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

<h2>Attendance Report</h2>

<div class="search-box">

<form method="POST">

<label>Select Date</label>

<input type="date"
name="attendance_date"
value="<?php echo $date; ?>">

<button type="submit" name="search">
Search
</button>

<button
type="button"
class="print-btn"
onclick="window.print()">
Print
</button>

</form>

</div>

<table>

<tr>

<th>ID</th>

<th>Employee Code</th>

<th>Employee Name</th>

<th>Date</th>

<th>Status</th>

</tr>

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

$statusClass="";

if($row['status']=="Present")
$statusClass="present";

if($row['status']=="Absent")
$statusClass="absent";

if($row['status']=="Leave")
$statusClass="leave";

if($row['status']=="Weekly Off")
$statusClass="weekoff";

if($row['status']=="Holiday")
$statusClass="holiday";

?>

<tr>

<td><?php echo $row['attendance_id']; ?></td>

<td><?php echo $row['employee_code']; ?></td>

<td><?php echo $row['employee_name']; ?></td>

<td><?php echo $row['attendance_date']; ?></td>

<td class="<?php echo $statusClass; ?>">
<?php echo $row['status']; ?>
</td>

</tr>

<?php

}

}
else
{
?>

<tr>

<td colspan="5">
No Attendance Records Found
</td>

</tr>

<?php
}
?>

</table>

</div>

</body>
</html>