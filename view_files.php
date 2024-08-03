<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$stmt = $conn->prepare('SELECT file_name, file_path FROM uploads WHERE user_id = (SELECT id FROM users WHERE username = ?)');
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<a href="' . $row['file_path'] . '">' . $row['file_name'] . '</a><br>';
}
?>
