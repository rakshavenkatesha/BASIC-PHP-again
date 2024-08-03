<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

include '../db.php';

echo "Admin Panel";
?>
