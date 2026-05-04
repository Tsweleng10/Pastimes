<?php
/**
 * loadClothingStore.php
 * Reads myClothingStore.sql and runs all SQL statements.
 */
require_once 'DBConn.php';

$sql = file_get_contents('myClothingStore.sql');
if ($sql === false) {
    die("Cannot read SQL file.");
}

// Execute multi-query
if (mysqli_multi_query($conn, $sql)) {
    do {
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));
    echo "Database populated successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>