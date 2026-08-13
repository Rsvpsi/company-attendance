<?php
session_start();
include("db.php");

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM employees WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['email'] = $email;
        $_SESSION['role'] = isset($user['role']) ? strtolower($user['role']) : 'employee';
        $_SESSION['employee_id'] = $user['employee_id'];
        $_SESSION['employee_name'] = $user['employee_name'];

        if (isset($user['role']) && strtolower($user['role']) === 'admin') {
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: employee_leave.php");
            exit();
        }
    } else {
        echo "<script>
            alert('Invalid Email or Password');
            window.location='login.html';
        </script>";
    }
}
?>