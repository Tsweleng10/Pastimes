<?php
/**
 * DBConn.php – connects to the ClothingStore database.
 */
$host = 'localhost';
$user = 'root';
$pass = '';              // empty password in XAMPP by default
$db   = 'ClothingStore';

// mysqli_connect returns a connection object if successful
$conn = mysqli_connect($host, $user, $pass, $db);

// If connection fails, stop the script and show an error
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set the character set to utf8 so special characters work
mysqli_set_charset($conn, "utf8");
?>