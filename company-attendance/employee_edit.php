<?php
include("db.php");

$id = $_GET['id'];

$sql = "SELECT * FROM employees WHERE employee_id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
</head>
<body>

<h2>Edit Employee</h2>

<form action="employee_update.php" method="POST">

<input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">

Employee Code:<br>
<input type="text" name="employee_code" value="<?php echo $row['employee_code']; ?>"><br><br>

Employee Name:<br>
<input type="text" name="employee_name" value="<?php echo $row['employee_name']; ?>"><br><br>

Department:<br>
<input type="text" name="department" value="<?php echo $row['department']; ?>"><br><br>

Phone:<br>
<input type="text" name="phone" value="<?php echo $row['phone']; ?>"><br><br>

Email:<br>
<input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>

Joining Date:<br>
<input type="date" name="joining_date" value="<?php echo $row['joining_date']; ?>"><br><br>

<input type="submit" value="Update Employee">

</form>

</body>
</html>