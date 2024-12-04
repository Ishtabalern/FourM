<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "UPDATE products SET price = '$price', stock = '$stock' WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Product updated successfully.</p>";
    } else {
        echo "<p>Error updating product: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            margin: 10px 0;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Update Product Prices and Stocks</h3>
        <form method="post" action="update_products.php">
            <label for="id">Product ID:</label>
            <input type="text" id="id" name="id" required>

            <label for="price">New Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>

            <label for="stock">New Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <input type="submit" value="Update">
        </form>

        <h3>Products</h3>
        <table>
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
    </div>
</body>
</html>
