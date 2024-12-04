<?php
include 'db.php';
?>

<h3>Stock Report</h3>
<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>Product ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
    </tr>
    <?php
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td>₱<?php echo number_format($row['price'], 2); ?></td>
        <td><?php echo $row['stock']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
