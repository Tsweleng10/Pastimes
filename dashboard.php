<?php
session_start();
// If not logged in, send back to login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'DBConn.php';

// Fetch all user data using an associative array
$stmt = mysqli_prepare($conn, "SELECT * FROM tbl_user WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>User <?php echo htmlspecialchars($user['full_name']); ?> is logged in</h2>
    <table>
        <tr><th>Field</th><th>Value</th></tr>
        <?php foreach ($user as $column => $value): ?>
            <tr>
                <td><?php echo htmlspecialchars($column); ?></td>
                <td><?php echo htmlspecialchars($value); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="products.php">View Clothes</a> | 
    <a href="logout.php">Logout</a>
</div>
</body>
</html>