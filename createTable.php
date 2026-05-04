 <?php
 error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'DBConn.php';   // include the connection

// 1. Drop tables in the correct order (child tables first)
/*
$drop_clothes = "DROP TABLE IF EXISTS tbl_clothes";
mysqli_query($conn, $drop_clothes);

$drop_user = "DROP TABLE IF EXISTS tbl_user";
if (!mysqli_query($conn, $drop_user)) {
    die("Error dropping tbl_user: " . mysqli_error($conn));
}
*/

// Only create the table if it doesn't exist yet
$create = "CREATE TABLE IF NOT EXISTS tbl_user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('buyer','seller','admin') DEFAULT 'buyer',
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create);


// 2. Create the table with the same structure we designed
$create = "CREATE TABLE tbl_user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('buyer','seller','admin') DEFAULT 'buyer',
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create);

// 3. Open the text file (read mode)
$file = fopen("userData.txt", "r") or die("Could not open userData.txt");

// 4. Read line by line using tab as delimiter
while (($line = fgetcsv($file, 1000, "\t")) !== false) {
    // $line is an array: [0] => full_name, [1] => email, [2] => password_hash, [3] => role, [4] => is_verified
    // Escape each string to prevent SQL injection (good practice)
    $full_name     = mysqli_real_escape_string($conn, $line[0]);
    $email         = mysqli_real_escape_string($conn, $line[1]);
    $pass_hash     = mysqli_real_escape_string($conn, $line[2]);
    $role          = mysqli_real_escape_string($conn, $line[3]);
    $verified      = (int)$line[4];           // convert to integer

    // Build the INSERT query
    $sql = "INSERT IGNORE INTO tbl_user (full_name, email, password_hash, role, is_verified)
        VALUES ('$full_name', '$email', '$pass_hash', '$role', $verified)";

    mysqli_query($conn, $sql);
}

fclose($file);

echo "tbl_user created and data loaded successfully.";
?>