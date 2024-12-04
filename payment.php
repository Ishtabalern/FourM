<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sale_id'])) {
    $sale_id = $_POST['sale_id'];
    $total = $_POST['total'];

    if (isset($_POST['payment_method']) && $_POST['payment_method'] == 'cash') {
        $amount_given = $_POST['amount_given'];
        if ($amount_given >= $total) {
            $change = $amount_given - $total;
            
            // Update the order status to 'Paid'
            $sql = "UPDATE sales SET status = 'Paid' WHERE id = $sale_id";
            if ($conn->query($sql) === TRUE) {
                // Redirect to receipt page
                header("Location: receipt.php?sale_id=$sale_id&change=$change");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('The amount given is less than the total amount. Please enter a valid amount.');</script>";
        }
    } else {
        // For card payment, assume the payment is always successful.
        // In a real application, you'd integrate with a payment gateway.

        // Update the order status to 'Paid'
        $sql = "UPDATE sales SET status = 'Paid' WHERE id = $sale_id";
        if ($conn->query($sql) === TRUE) {
            // Redirect to receipt page
            header("Location: receipt.php?sale_id=$sale_id&change=0");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
} else if (isset($_GET['sale_id']) && isset($_GET['total'])) {
    $sale_id = $_GET['sale_id'];
    $total = $_GET['total'];
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
    <title>Payment</title>
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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
        }
        .payment-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .payment-form input, .payment-form button {
            padding: 10px;
            margin: 10px 0;
            width: 300px;
        }
        .payment-form button {
            background-color: #e46f57;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .payment-form button:hover {
            background-color: #f14b2a;
        }
        .payment-method {
            margin: 20px 0;
        }
        .payment-method img{
            margin-left: 215px;
            margin-top: -10px;
            position: absolute;
            width: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment</h1>
        <form class="payment-form" method="POST" action="payment.php">
            <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>">
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <p>Total Amount: ₱<?php echo number_format($total, 2); ?></p>
            
            <div class="payment-method">
                <label>
                    <img src="img/cliparts/credit.png" alt="">
                    <input type="radio" name="payment_method" value="card" checked> Credit/Debit Card
                </label>
                <label>
                    <img src="img/cliparts/cash.png" alt="">
                    <input type="radio" name="payment_method" value="cash"> Cash
                </label>
            </div>

            <div id="card-info">
                <input type="text" name="card_number" placeholder="Card Number">
                <input type="text" name="card_name" placeholder="Name on Card">
                <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YY)">
                <input type="text" name="cvv" placeholder="CVV">
            </div>

            <div id="cash-info" style="display: none;">
                <input type="number" step="0.01" name="amount_given" placeholder="Amount Given">
            </div>

            <button type="submit">Pay Now</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                var value = event.target.value;
                if (value == 'cash') {
                    document.getElementById('card-info').style.display = 'none';
                    document.getElementById('cash-info').style.display = 'block';
                } else {
                    document.getElementById('card-info').style.display = 'block';
                    document.getElementById('cash-info').style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
