<?php
$conn = new mysqli('localhost','root','','company_attendance');
if ($conn->connect_error) { die($conn->connect_error); }

$check = $conn->query("SHOW COLUMNS FROM employees LIKE 'role'");
if ($check->num_rows == 0) {
    $conn->query("ALTER TABLE employees ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'employee'");
}

$email = 'admin@company.com';
$password = 'admin123';

$result = $conn->query("SELECT employee_id FROM employees WHERE email='$email'");
if ($result->num_rows > 0) {
    $conn->query("UPDATE employees SET password='$password', role='admin', employee_name='Admin' WHERE email='$email'");
} else {
    $conn->query("INSERT INTO employees (employee_code, employee_name, department, phone, email, joining_date, password, role) VALUES ('100', 'Admin', 'Management', '0000000000', '$email', '2024-01-01', '$password', 'admin')");
}

echo 'Admin account ready. Email: ' . $email . ' Password: ' . $password;
$conn->close();
