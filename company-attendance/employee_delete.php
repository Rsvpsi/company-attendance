<?php
include("db.php");

$id = $_GET['id'];

$sql = "DELETE FROM employees WHERE employee_id='$id'";

if(mysqli_query($conn, $sql))
{
    echo "<script>
    alert('Employee Deleted Successfully');
    window.location='employee.php';
    </script>";
}
else
{
    echo "Delete Failed";
}
?>