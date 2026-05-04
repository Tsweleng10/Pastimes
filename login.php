<?php
session_start();    // start session to remember the logged-in user
require_once 'DBConn.php';

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email == '' || $password == '') {
        $error = 'Both fields are required.';
    } else {
        // Look up user by email
        $stmt = mysqli_prepare($conn, "SELECT user_id, full_name, password_hash, role, is_verified FROM tbl_user WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Check password using MD5 (same hash as in table)
            if (md5($password) === $row['password_hash']) {
                // Check if user is verified (admin can always log in)
                if ($row['role'] != 'admin' && $row['is_verified'] == 0) {
                    $error = 'Your account is not yet verified by an administrator. Please wait.';
                } else {
                    // Valid login – store user info in session
                    $_SESSION['user_id']   = $row['user_id'];
                    $_SESSION['full_name'] = $row['full_name'];
                    $_SESSION['role']      = $row['role'];
                    // Redirect to dashboard
                    header('Location: dashboard.php');
                    exit();
                }
            } else {
                $error = 'Incorrect password.';
            }
        } else {
            $error = 'No account found with that email.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Login to Pastimes</h1>
    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label>Email</label>
        <input type="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
        <!-- The "value" attribute keeps the email if the form is re-displayed (sticky) -->

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Log In</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
    <p><a href="admin.php">Admin Login</a></p>
</div>
</body>
</html>