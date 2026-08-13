<?php
include("db.php");

$employee_code = $_POST['employee_code'];
$employee_name = $_POST['employee_name'];
$department = $_POST['department'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$joining_date = $_POST['joining_date'];
$password = $_POST['password'];

$sql = "INSERT INTO employees
(employee_code, employee_name, department, phone, email, joining_date, password)
VALUES
('$employee_code','$employee_name','$department','$phone','$email','$joining_date','$password')";

if(mysqli_query($conn,$sql))
{
    echo "<script>
    alert('Employee Added Successfully');
    window.location='employee.php';
    </script>";
}
else
{
    echo "Error: ".mysqli_error($conn);
}
?>