<?php
$host = "localhost";
$user = "test";
$pass = "test";
$db   = "bincomphp";

// Create connection (OOP style)
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
