<?php
include("db.php");

$id = $_POST['employee_id'];
$code = $_POST['employee_code'];
$name = $_POST['employee_name'];
$department = $_POST['department'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$joining = $_POST['joining_date'];

$sql = "UPDATE employees SET
employee_code='$code',
employee_name='$name',
department='$department',
phone='$phone',
email='$email',
joining_date='$joining'
WHERE employee_id='$id'";

if(mysqli_query($conn, $sql))
{
    echo "<script>
    alert('Employee Updated Successfully');
    window.location='employee.php';
    </script>";
}
else
{
    echo "Update Failed";
}
?>