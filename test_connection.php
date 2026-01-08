<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'guvi_internship');
if($conn->connect_error) {
    echo 'Connection failed: ' . $conn->connect_error . "\n";
} else {
    echo 'Connected successfully!' . "\n";
    $conn->close();
}
