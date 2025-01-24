<?php
include 'db.php';
session_start();

if (isset($_GET['sale_id']) && isset($_GET['change'])) {
    $sale_id = $_GET['sale_id'];
    $change = $_GET['change'];

    // Get sale details
    $sql = "SELECT * FROM sales WHERE id = $sale_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sale = $result->fetch_assoc();
        $queue_number = $sale['queue_number'];
        $total = $sale['total'];
    } else {
        echo "Sale not found.";
        exit();
    }

    // Get sale items
    $sql = "SELECT si.quantity, si.price, p.name 
            FROM sales_items si 
            JOIN products p ON si.product_id = p.id 
            WHERE si.sale_id = $sale_id";
    $items_result = $conn->query($sql);
    $items = [];
    if ($items_result->num_rows > 0) {
        while($row = $items_result->fetch_assoc()) {
            $items[] = $row;
        }
    } else {
        echo "No items found for this sale.";
        exit();
    }
} else {
    // Redirect back to order page if no sale_id is provided
    header('Location: order.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 60%;
        margin: 0 auto;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
        border-radius: 10px;
    }

    h1, h2, h3 {
        text-align: center;
        color: #333;
    }

    h1 {
        font-size: 28px;
        color: #e77a00;
    }

    h2 {
        font-size: 20px;
        color: #555;
    }

    .receipt {
        margin-top: 20px;
    }

    .receipt table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .receipt th, .receipt td {
        padding: 12px;
        text-align: center;
        font-size: 16px;
        border: 1px solid #ddd;
    }

    .receipt th {
        background-color: #e77a00;
        color: #fff;
        font-weight: bold;
    }

    .receipt td {
        background-color: #f9f9f9;
    }

    .receipt tr:nth-child(even) td {
        background-color: #f1f1f1;
    }

    .receipt .total {
        font-weight: bold;
        background-color: #f9f9f9;
        font-size: 18px;
        color: #333;
    }

    .receipt .change {
        font-weight: bold;
        background-color: #e9f7ef;
        font-size: 18px;
        color: #28a745;
    }

    .back-button {
        display: block;
        width: 220px;
        margin: 30px auto;
        padding: 12px;
        background-color: #e46f57;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
    }

    .back-button:hover {
        background-color: #f14b2a;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .receipt .change span {
        font-size: 18px;
        color: #28a745;
    }

    /* Add a subtle shadow on the table rows */
    .receipt tr {
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .receipt tr:hover {
        background-color: #fff8e1;
        transform: translateY(-2px);
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Thank You for Your Order!</h1>
        <h2>Queue Number: <?php echo $queue_number; ?></h2>
        <div class="receipt">
            <h3>Receipt</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>₱<?php echo number_format($item['price'], 2); ?></td>
                        <td>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="total">
                        <td colspan="3">Total</td>
                        <td>₱<?php echo number_format($total, 2); ?></td>
                    </tr>
                    <tr class="change">
                        <td colspan="3">Change</td>
                        <td>₱<?php echo number_format($change, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="order.php" class="back-button">Back to Order Page</a>
    </div>
</body>
</html>
