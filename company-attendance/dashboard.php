<?php

session_start();
include("db.php");


if (!isset($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}


// Today's Date
$today = date("Y-m-d");


// Total Employees
$total_query = mysqli_query($conn,
"SELECT COUNT(*) AS total FROM employees");

$total = mysqli_fetch_assoc($total_query)['total'];



// Present Count

$present_query = mysqli_query($conn,
"SELECT COUNT(*) AS total 
FROM attendance 
WHERE attendance_date='$today'
AND status='Present'");

$present = mysqli_fetch_assoc($present_query)['total'];



// Absent Count

$absent_query = mysqli_query($conn,
"SELECT COUNT(*) AS total 
FROM attendance 
WHERE attendance_date='$today'
AND status='Absent'");

$absent = mysqli_fetch_assoc($absent_query)['total'];



// Leave Count

$leave_query = mysqli_query($conn,
"SELECT COUNT(*) AS total 
FROM attendance 
WHERE attendance_date='$today'
AND status='Leave'");

$leave = mysqli_fetch_assoc($leave_query)['total'];



?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>


<style>


body{

margin:0;
font-family:Arial;
background:#f1f5f9;

}


/* Sidebar */

.sidebar{

position:fixed;
width:250px;
height:100vh;
background:#1e3a8a;
color:white;
padding:20px;

}


.sidebar h2{

text-align:center;

}


.sidebar a{

display:block;
color:white;
text-decoration:none;
padding:15px;
margin:8px 0;
border-radius:8px;

}


.sidebar a:hover{

background:#2563eb;

}



/* Main */

.main{

margin-left:290px;
padding:30px;

}



.header{

background:white;
padding:20px;
border-radius:15px;

}


.cards{

display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-top:25px;

}



.card{

background:white;
padding:25px;
border-radius:15px;
box-shadow:0 5px 15px #ddd;

}


.card h3{

color:#64748b;

}


.number{

font-size:35px;
font-weight:bold;

}


.blue{

color:#2563eb;

}


.green{

color:#16a34a;

}


.red{

color:#dc2626;

}


.orange{

color:#f59e0b;

}



/* Attendance Table */


.box{

background:white;
padding:25px;
margin-top:30px;
border-radius:15px;

}


.warning-card{

background:#fff7ed;
border:1px solid #f59e0b;
box-shadow:0 5px 15px #fde68a;

}


.warning-box{

background:#fff7ed;
border:1px solid #f59e0b;

}


.warning-title{

color:#b45309;

}


.warning-text{

color:#b45309;
font-weight:bold;

}


table{

width:100%;
border-collapse:collapse;

}


th{

background:#2563eb;
color:white;
padding:12px;

}


td{

padding:12px;
border-bottom:1px solid #ddd;
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


</style>


</head>



<body>


<div class="sidebar">


<h2>ABC COMPANY</h2>


<a href="dashboard.php">
🏠 Dashboard
</a>


<a href="employee.php">
👨 Employees
</a>


<a href="attendance.php">
📅 Attendance
</a>


<a href="leave.php">
📝 Leave
</a>


<a href="report.php">
📊 Reports
</a>


<a href="logout.php">
🚪 Logout
</a>


</div>





<div class="main">


<div class="header">

<h1>
Admin Dashboard
</h1>

<p>
Employee Attendance Management System
</p>


<h3>
Today's Date : <?php echo $today; ?>
</h3>


</div>




<div class="cards">


<div class="card">

<h3>Total Employees</h3>

<div class="number blue">

<?php echo $total; ?>

</div>

</div>




<div class="card">

<h3>Present Today</h3>

<div class="number green">

<?php echo $present; ?>

</div>

</div>




<div class="card">

<h3>Absent Today</h3>

<div class="number red">

<?php echo $absent; ?>

</div>

</div>




<div class="card">

<h3>Leave Today</h3>

<div class="number orange">

<?php echo $leave; ?>

</div>

</div>





</div>





<div class="box">


<h2>
Today's Attendance
</h2>



<table>


<tr>

<th>Employee Name</th>

<th>Department</th>

<th>Date</th>

<th>Status</th>

</tr>



<?php


$sql="SELECT attendance.*,
employees.employee_name,
employees.department

FROM attendance

INNER JOIN employees

ON attendance.employee_id = employees.employee_id

WHERE attendance.attendance_date='$today'";


$result=mysqli_query($conn,$sql);



if(mysqli_num_rows($result)>0)

{


while($row=mysqli_fetch_assoc($result))

{


?>


<tr>


<td>

<?php echo $row['employee_name']; ?>

</td>


<td>

<?php echo $row['department']; ?>

</td>


<td>

<?php echo $row['attendance_date']; ?>

</td>



<td class="<?php echo strtolower($row['status']); ?>">


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

<td colspan="4">

No Attendance Marked Today

</td>

</tr>


<?php

}


?>



</table>


</div>



</div>


</body>

</html>