<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$username = 'admin';
$password = 'admin123';
$email = 'admin@ok.com';
$role = 'admin';

$stmt = $conn->prepare('INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)');
$stmt->bind_param('ssss', $username, $password, $email, $role);
if ($stmt->execute()) {
    echo "admin done.";
} else {
    echo "Error: " . $stmt->error;
}
?>
