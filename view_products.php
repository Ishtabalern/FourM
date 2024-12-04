<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #28a745;
            background-image: url(img/bg.png);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9e4bc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #fff;
            font-weight: 1000;
            font-size: 60px;
            -webkit-text-stroke: 2px;
            -webkit-text-stroke-color: red;
            margin-top: 5px;
            margin-bottom: 15px;
            
        }
        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            width: 100%;
        }
        .product {
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 10px;
            background-color: #FBFAE3;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product img {
            max-width: 250px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .product label {
            text-align: center;
            width: 100%;
        }
        .order-button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }
        .order-button:hover {
            background-color: #0056b3;
        }
        .order-now-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Our Products</h2>
        <div class="products">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
            <div class="product" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-price="<?php echo $row['price']; ?>">
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                <label>
                    <?php echo $row['name']; ?> - ₱<?php echo $row['price']; ?> (Stock: <?php echo $row['stock']; ?>)
                </label>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="order-now-container">
            <a href="order.php" class="order-button">Order Now</a>
        </div>
    </div>
</body>
</html>
