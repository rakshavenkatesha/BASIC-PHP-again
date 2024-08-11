<?php
$servername = "localhost";
$username = "rakshavenkatesha";
$password = "password123";
$dbname = "tryagain";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

