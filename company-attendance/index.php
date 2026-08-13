<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance Management System</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="logo">
        <h2>ABC Company</h2>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="employee.php">Employees</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="leave.php">Leave</a></li>
            <li><a href="report.php">Reports</a></li>
        </ul>
    </nav>
</header>

<section class="hero">
    <div class="hero-content">
        <h1>Employee Attendance Management System</h1>

        <p>
            Welcome to the Employee Attendance Management System.
            Manage employee records, attendance, leave requests,
            weekly off, holidays, and reports from one dashboard.
        </p>

        <a href="login.html" class="btn">Login</a>
    </div>
</section>

<section class="features">

    <div class="card">
        <h3>👨‍💼 Employee Management</h3>
        <p>Add, update, delete and manage employee information.</p>
    </div>

    <div class="card">
        <h3>📅 Attendance</h3>
        <p>Mark Present, Absent, Leave, Weekly Off and Holidays.</p>
    </div>

    <div class="card">
        <h3>📝 Leave Management</h3>
        <p>Employees can apply for leave and managers can approve or reject requests.</p>
    </div>

    <div class="card">
        <h3>📊 Reports</h3>
        <p>View daily, weekly and monthly attendance reports.</p>
    </div>

</section>

<footer>
    <p>&copy; 2026 ABC Company | Employee Attendance Management System</p>
</footer>

</body>
</html>