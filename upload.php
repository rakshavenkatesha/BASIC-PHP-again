<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_path = 'uploads/' . $file_name;

    if (move_uploaded_file($file_tmp, $file_path)) {
        $stmt = $conn->prepare('INSERT INTO uploads (user_id, file_name, file_path) VALUES ((SELECT id FROM users WHERE username = ?), ?, ?)');
        $stmt->bind_param('sss', $_SESSION['username'], $file_name, $file_path);
        if ($stmt->execute()) {
            echo "File uploaded successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Failed to upload file";
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" required><br>
    <button type="submit">Upload</button>
</form>
