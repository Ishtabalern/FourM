<?php
include 'db.php';
?>

<h3>Sales Report</h3>
<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>Sale ID</th>
        <th>Queue Number</th>
        <th>Total</th>
        <th>Date</th>
    </tr>
    <?php
    $sql = "SELECT * FROM sales";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['queue_number']; ?></td>
        <td>₱<?php echo number_format($row['total'], 2); ?></td>
        <td><?php echo $row['date']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
