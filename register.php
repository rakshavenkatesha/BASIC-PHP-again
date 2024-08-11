<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = "use letters, nos, and _";
    } else {

        $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "username/email exists.";
        } else {

            $stmt = $conn->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $username, $password, $email);
            if ($stmt->execute()) {
                echo "<script>alert('registered :) going to the login page. login again.'); window.location.href = 'login.php';</script>";
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <?php if (isset($error)) { echo '<p>' . $error . '</p>'; } ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
