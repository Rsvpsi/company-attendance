<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "company_attendance";

// Create Connection
$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Uncomment the line below if you want to test the connection
// echo "Database Connected Successfully";

?>