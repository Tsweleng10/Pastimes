<?php
session_start();
require_once 'DBConn.php';

// Check admin rights
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handle approve/delete actions via GET parameters
if (isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    mysqli_query($conn, "UPDATE tbl_user SET is_verified = 1 WHERE user_id = $id AND role != 'admin'");
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM tbl_user WHERE user_id = $id AND role != 'admin'");
}

// Fetch all users except the current admin
$users = mysqli_query($conn, "SELECT * FROM tbl_user WHERE user_id != {$_SESSION['user_id']} ORDER BY is_verified ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Admin Panel</h1>
    <p>Logged in as <?php echo $_SESSION['full_name']; ?></p>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Verified</th><th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($users)): ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td><?php echo $row['is_verified'] ? 'Yes' : 'No'; ?></td>
            <td>
                <?php if ($row['is_verified'] == 0): ?>
                    <a href="?approve=<?php echo $row['user_id']; ?>">Approve</a>
                <?php endif; ?>
                <a href="?delete=<?php echo $row['user_id']; ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="dashboard.php">My Dashboard</a> | <a href="logout.php">Logout</a></p>
</div>
</body>
</html>