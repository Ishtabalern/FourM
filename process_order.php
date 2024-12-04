<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = json_decode($_POST['cart'], true);
    $total = 0;

    // Get the highest current queue number
    $result = $conn->query("SELECT MAX(queue_number) AS max_queue FROM sales");
    $row = $result->fetch_assoc();
    $max_queue = $row['max_queue'] ?? 0;
    $queue_number = $max_queue + 1;

    // Insert into sales table
    $sql = "INSERT INTO sales (total, queue_number, status) VALUES (0, $queue_number, 'Pending')";
    if ($conn->query($sql) === TRUE) {
        $sale_id = $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit();
    }

    // Insert each item into sales_items table and update product stock
    foreach ($cart as $product_id => $product) {
        $quantity = $product['quantity'];
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

    // Close the connection
    $conn->close();
    
    // Redirect to payment page
    echo "
    <html>
        <head>
            <script>
                function redirectToPayment() {
                    alert('Thank you for your order! You will now be redirected to the payment page.');
                    window.location.href = 'payment.php?sale_id=$sale_id&total=$total';
                }
                setTimeout(redirectToPayment, 1000); // 1 second delay before redirect
            </script>
        </head>
        <body>
        </body>
    </html>
    ";
}
?>
