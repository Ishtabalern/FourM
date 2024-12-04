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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        h1, h2, h3 {
            text-align: center;
        }
        .receipt {
            margin-top: 20px;
        }
        .receipt table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt table, .receipt th, .receipt td {
            border: 1px solid black;
        }
        .receipt th, .receipt td {
            padding: 10px;
            text-align: left;
        }
        .receipt .total {
            font-weight: bold;
        }
        .receipt .change {
            color: green;
            font-weight: bold;
        }
        .back-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #e46f57;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #f14b2a;
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
