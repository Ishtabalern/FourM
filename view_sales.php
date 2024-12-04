<?php
include 'db.php';

$sql = "SELECT * FROM sales";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales History</title>
</head>
<body>
    <h2>Sales History</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['total']; ?></td>
            <td><?php echo $row['date']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
