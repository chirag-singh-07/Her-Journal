<?php
$host = "localhost";    // usually "localhost"
$user = "root";         // your MySQL username
$pass = "";             // your MySQL password
$db   = "her_journal";  // database name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
