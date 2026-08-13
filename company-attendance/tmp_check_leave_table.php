<?php
$conn = new mysqli('localhost','root','','company_attendance');
if ($conn->connect_error) { die($conn->connect_error); }
$result = $conn->query('SHOW COLUMNS FROM leave_requests');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo json_encode($row) . PHP_EOL;
    }
} else {
    echo 'TABLE_MISSING';
}
$conn->close();
