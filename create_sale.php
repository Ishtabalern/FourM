<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $products = $_POST['products'];
    $total = 0;

    // Insert into sales table
    $sql = "INSERT INTO sales (total) VALUES (0)";
    if ($conn->query($sql) === TRUE) {
        $sale_id = $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Insert into sales_items table
    foreach ($products as $product_id => $quantity) {
        $sql = "SELECT price FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        $product = $result->fetch_assoc();
        $price = $product['price'];
        $total += $price * $quantity;

        $sql = "INSERT INTO sales_items (sale_id, product_id, quantity, price) VALUES ('$sale_id', '$product_id', '$quantity', '$price')";
        if ($conn->query($sql) === TRUE) {
            // Update stock
            $sql = "UPDATE products SET stock = stock - $quantity WHERE id = $product_id";
            $conn->query($sql);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Update total in sales table
    $sql = "UPDATE sales SET total = $total WHERE id = $sale_id";
    $conn->query($sql);

    echo "Sale completed successfully";
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Sale</title>
</head>
<body>
    <h2>Create Sale</h2>
    <form method="post">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()):
        ?>
        <div>
            <input type="checkbox" name="products[<?php echo $row['id']; ?>]" value="1">
            <?php echo $row['name']; ?> - $<?php echo $row['price']; ?> (Stock: <?php echo $row['stock']; ?>)
        </div>
        <?php endwhile; ?>
        <input type="submit" value="Complete Sale">
    </form>
</body>
</html>
