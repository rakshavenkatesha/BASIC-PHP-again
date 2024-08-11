<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    $fileType = $_FILES['file']['type'];

    if (in_array($fileType, $allowedTypes)) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {

            $stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->bind_param('s', $_SESSION['username']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $user_id = $user['id'];


            $stmt = $conn->prepare('INSERT INTO uploads (user_id, file_name, file_path) VALUES (?, ?, ?)');
            $stmt->bind_param('iss', $user_id, $_FILES['file']['name'], $uploadFile);
            if ($stmt->execute()) {
                echo "file uploaded";
            } else {
                echo "cant store file info " . $stmt->error;
            }
        } else {
            echo "upload failed.";
        }
    } else {
        echo " Only JPEG,JPG, PNG, and PDF files are allowed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>
    <h1>Upload File</h1>
    <form enctype="multipart/form-data" method="post">
        <input type="file" name="file" required><br>
        <button type="submit">Upload</button>
    </form>
    <a href="view_files.php">View Files</a>
    <a href="logout.php">Logout</a>
</body>
</html>
