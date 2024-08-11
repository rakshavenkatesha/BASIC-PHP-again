<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

include '../db.php';

// Fetch all users
$users_stmt = $conn->prepare('SELECT id, username, email, role FROM users');
$users_stmt->execute();
$users_result = $users_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - View Users</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>

    <h3>Registered Users</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php while ($user = $users_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['role']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="../logout.php">Logout</a>
</body>
</html>
