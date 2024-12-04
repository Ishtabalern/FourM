<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO products (name, price, stock) VALUES ('$name', '$price', '$stock')";
    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form method="post">
        Name: <input type="text" name="name" required><br>
        Price: <input type="number" step="0.01" name="price" required><br>
        Stock: <input type="number" name="stock" required><br>
        <input type="submit" value="Add Product">
    </form>
</body>
</html>
