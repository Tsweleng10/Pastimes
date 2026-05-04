<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'DBConn.php';

// 1. Create the table only if it doesn't exist 
$create = "CREATE TABLE IF NOT EXISTS tbl_clothes (
    clothes_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255),
    status ENUM('available','sold') DEFAULT 'available',
    FOREIGN KEY (seller_id) REFERENCES tbl_user(user_id) ON DELETE SET NULL
)";
if (!mysqli_query($conn, $create)) {
    die("Error creating table: " . mysqli_error($conn));
}
echo "Table tbl_clothes ready.<br>";

// 2. Load data from clothesData.txt
$file = fopen("clothesData.txt", "r");
if (!$file) {
    die("Could not open clothesData.txt. Make sure it exists in the pastimes folder.");
}

$count = 0;
while (($line = fgetcsv($file, 1000, "\t")) !== false) {
    // $line = [seller_id, title, description, price, image_path]
    $seller_id   = (int)$line[0];
    $title       = mysqli_real_escape_string($conn, $line[1]);
    $description = mysqli_real_escape_string($conn, $line[2]);
    $price       = (float)$line[3];
    $image_path  = mysqli_real_escape_string($conn, $line[4]);

    $sql = "INSERT IGNORE INTO tbl_clothes (seller_id, title, description, price, image_path)
            VALUES ($seller_id, '$title', '$description', $price, '$image_path')";
    if (mysqli_query($conn, $sql)) {
        if (mysqli_affected_rows($conn) > 0) {
            $count++;
        }
    } else {
        echo "Error inserting '$title': " . mysqli_error($conn) . "<br>";
    }
}
fclose($file);

echo "$count new clothes added (skipped duplicates).<br>";
echo "Done. <a href='products.php'>View Clothes</a>";
?>