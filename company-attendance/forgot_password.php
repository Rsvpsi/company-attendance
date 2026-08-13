<?php
include("db.php");

$email = $_POST['email'];

$sql = "SELECT * FROM employees WHERE email='$email'";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0)
{
    $row = mysqli_fetch_assoc($result);

    echo "<h2>Password Recovery</h2>";

    echo "Employee Name : ".$row['employee_name']."<br><br>";

    echo "Your Password is : <b>".$row['password']."</b>";

    echo "<br><br><a href='login.html'>Back to Login</a>";
}
else
{
    echo "<script>

    alert('Email Not Found');

    window.location='forgot_password.html';

    </script>";
}
?>