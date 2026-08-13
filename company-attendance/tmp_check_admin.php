<?php
$conn = new mysqli('localhost','root','','company_attendance');
if ($conn->connect_error) { die($conn->connect_error); }
$result = $conn->query("SELECT employee_id, employee_code, employee_name, email, password FROM employees ORDER BY employee_id ASC");
while ($row = $result->fetch_assoc()) {
    echo json_encode($row, JSON_UNESCAPED_SLASHES) . PHP_EOL;
}
$conn->close();
