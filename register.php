<?php
require_once 'DBConn.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data
    $full_name      = trim($_POST['full_name']);
    $email          = trim($_POST['email']);
    $password       = $_POST['password'];
    $confirm        = $_POST['confirm_password'];

    // Server-side validation 
    if ($full_name=='' || $email=='' || $password=='') {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $check = mysqli_prepare($conn, "SELECT user_id FROM tbl_user WHERE email = ?");
        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $error = 'This email is already registered.';
        } else {
            // Hash the password using MD5 
            $hash = md5($password);

            // Insert new user (role = 'buyer' by default, unverified)
            $stmt = mysqli_prepare($conn, "INSERT INTO tbl_user (full_name, email, password_hash, role, is_verified) VALUES (?, ?, ?, 'buyer', 0)");
            mysqli_stmt_bind_param($stmt, "sss", $full_name, $email, $hash);

            if (mysqli_stmt_execute($stmt)) {
                $success = 'Account created! Wait for admin approval before you can log in.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Register for Pastimes</h1>
    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label>Full Name *</label>
        <input type="text" name="full_name" required>

        <label>Email *</label>
        <input type="email" name="email" required>

        <label>Password *</label>
        <input type="password" name="password" required>

        <label>Confirm Password *</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>