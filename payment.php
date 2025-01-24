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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 350px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .payment-form {
            display: flex;
            flex-direction: column;
        }
        .payment-form input, .payment-form button {
            padding: 10px;
            margin: 8px 0;
            width: 100%;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .payment-form button {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }
        .payment-form button:hover {
            background-color: #4cae4c;
        }
        .payment-method {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .payment-method label {
            display: flex;
            align-items: center;
        }
        .payment-method i {
            margin-right: 8px;
        }
        #card-info, #cash-info {
            display: none;
        }
        #total {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment</h1>
        <form class="payment-form" method="POST" action="payment.php">
            <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>">
            <input type="hidden" name="total" value="<?php echo $total; ?>">

            <div id="total">Total: ₱<?php echo number_format($total, 2); ?></div>
            
            <div class="payment-method">
                <label>
                    <i class="fas fa-credit-card"></i> 
                    <input type="radio" name="payment_method" value="card" checked> Card
                </label>
                <label>
                    <i class="fas fa-money-bill-wave"></i>
                    <input type="radio" name="payment_method" value="cash"> Cash
                </label>
            </div>

            <div id="card-info">
                <input type="text" name="card_number" placeholder="Card Number">
                <input type="text" name="card_name" placeholder="Cardholder Name">
                <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YY)">
                <input type="text" name="cvv" placeholder="CVV">
            </div>

            <div id="cash-info">
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
