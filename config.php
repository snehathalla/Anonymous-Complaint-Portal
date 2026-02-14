<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hack_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Note: Removed the login query that used undefined $username and $password.
// Authentication should be performed in the login script (e.g. admin-login.php).
?>