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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Products</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #495057;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            font-size: 1.4em;
            font-weight: 500;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 1em;
            font-weight: 400;
            color: #495057;
        }
        input[type="text"], input[type="number"] {
            padding: 8px;
            font-size: 1em;
            border: 1px solid #ced4da;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #007bff;
        }
        input[type="submit"] {
            padding: 10px 18px;
            font-size: 1em;
            color: #fff;
            background-color: #ff5500;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color:rgb(211, 123, 79);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font-size: 0.95em;
        }
        th {
            background-color: #f1f3f5;
            color: #495057;
            font-weight: 500;
        }
        td {
            background-color: #ffffff;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
        }
        tr:hover td {
            background-color: #f8f9fa;
        }
        /* Mobile responsive */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
            h3 {
                font-size: 1.2em;
            }
            input[type="submit"] {
                font-size: 0.95em;
                padding: 8px 14px;
            }
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

        <h3>Product List</h3>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
</body>
</html>
