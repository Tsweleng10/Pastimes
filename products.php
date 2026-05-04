<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'DBConn.php';

$sql = "SELECT clothes_id, title, description, price, image_path FROM tbl_clothes WHERE status = 'available'";
$result = mysqli_query($conn, $sql);

// Fetch all rows into an array
$clothes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $clothes[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Clothes for Sale</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Available Clothes</h2>
    <?php if (count($clothes) > 0): ?>
        <table>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            <?php foreach ($clothes as $item): ?>
            <tr>
                <td><img src="images/<?php echo htmlspecialchars($item['image_path']); ?>" alt="Clothes" class="cloth-img"></td>
                <td><?php echo htmlspecialchars($item['title']); ?></td>
                <td><?php echo htmlspecialchars($item['description']); ?></td>
                <td>R<?php echo number_format($item['price'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No items found.</p>
    <?php endif; ?>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>