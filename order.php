<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Products</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: center; /* Center align the navigation links */
            align-items: center;
            padding: 15px -20px;
            background-color: rgb(238, 113, 68);
            color: #fff;
            position: fixed;
            top: 0;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
                }

        .navbar img {
            width: 80px;
            position: relative;
           
        }

        .navbar nav {
            display: flex;
            gap: 20px;
        }

        .navbar nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .navbar nav a:hover {
            color: #ffa382;
        }

        /* Main Container */
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 100px;
            padding: 0 30px;
        }

        .products {
            flex: 1 1 65%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .product {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        .products h2 {
    grid-column: 1 / -1; 
    text-align: center;
    font-size: 28px;
    color: #ff7043;
    font-weight: 700;
    margin-bottom: 20px;
}


        .product img {
            width: 100%;
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 8px;
        }
        .product h4 {
            font-size: 18px;
            font-weight: 700;
            margin: 10px 0;
            color: #333;
        }

        .product p {
            font-size: 14px;
            color: #777;
            margin: 10px 0 15px;
        }

        .product .price {
            font-size: 20px;
            font-weight: bold;
            color: #ff7043;
            margin-bottom: 15px;
        }

        .quantity-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .quantity-controls button {
            background-color: #ff7043;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .quantity-controls button:hover {
            background-color: #e66038;
        }

        .quantity-controls span {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .product .add-to-cart {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff7043;
            color: #fff;
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .product .add-to-cart:hover {
            background-color: #c5001f;
        }

        /* Cart Styles */
        .cart {
            flex: 1 1 30%;
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 100px;
            max-height: calc(100vh - 150px);
            overflow-y: auto;
        }

        .cart h3 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .cart .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
            color: #555;
        }

        .cart .cart-item button {
            background-color: #ff7043;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .cart .cart-item button:hover {
            background-color: #e66038;
        }

        .cart #totalCost {
            font-weight: 700;
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        .cart .place-order {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #ff7043;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-align: center;
            text-transform: uppercase;
            font-size: 16px;
            font-weight: 700;
            margin-top: 20px;
            cursor: pointer;
        }

        .cart .place-order:hover {
            background-color: #e66038;
        }
        .low-stock-warning {
            color: #e67e22;
            font-weight: bold;
        }
        .no-stock {
            color: #e74c3c;
            font-weight: bold;
        }

    </style>
    <script>
        let cart = {};

        function addToCart(productId, productName, productPrice, maxQuantity) {
            const quantity = parseInt(document.getElementById(`quantity_value_${productId}`).innerText);

            if (quantity > 0 && quantity <= maxQuantity) {
                if (cart[productId]) {
                    cart[productId].quantity += quantity;
                } else {
                    cart[productId] = { name: productName, price: productPrice, quantity: quantity };
                }
                document.getElementById(`quantity_value_${productId}`).innerText = 0; // Reset quantity display
                showCartSummary();
            } else {
                alert(`Please enter a valid quantity (1-${maxQuantity})`);
            }
        }

        function increaseQuantity(productId, maxQuantity) {
            const quantityElement = document.getElementById(`quantity_value_${productId}`);
            let quantity = parseInt(quantityElement.innerText);
            if (quantity < maxQuantity) {
                quantityElement.innerText = quantity + 1;
            }
        }

        function decreaseQuantity(productId) {
            const quantityElement = document.getElementById(`quantity_value_${productId}`);
            let quantity = parseInt(quantityElement.innerText);
            if (quantity > 0) {
                quantityElement.innerText = quantity - 1;
            }
        }

        function removeFromCart(productId) {
            delete cart[productId];
            showCartSummary();
        }

        function calculateTotal() {
            let total = 0;
            for (const productId in cart) {
                total += cart[productId].price * cart[productId].quantity;
            }
            return total.toFixed(2);
        }

        function showCartSummary() {
            const cartSummary = document.getElementById('cartSummary');
            cartSummary.innerHTML = '';
            for (const productId in cart) {
                const item = document.createElement('div');
                item.classList.add('cart-item');
                item.innerHTML = `
                    ${cart[productId].name} - ₱${cart[productId].price} x ${cart[productId].quantity} = ₱${(cart[productId].price * cart[productId].quantity).toFixed(2)}
                    <button onclick="removeFromCart(${productId})">Remove</button>
                `;
                cartSummary.appendChild(item);
            }
            document.getElementById('totalCost').innerText = `Total: ₱${calculateTotal()}`;
        }

        function submitOrder() {
            const form = document.getElementById('orderForm');
            const cartInput = document.createElement('input');
            cartInput.type = 'hidden';
            cartInput.name = 'cart';
            cartInput.value = JSON.stringify(cart);
            form.appendChild(cartInput);
            return confirm('Are you sure you want to place this order?');
        }
    </script>
</head>
<body>
<div class="navbar">
        <a href="index.html">
            <img src="img/logo.png" alt="Logo">
        </a>
        <nav>
            <a href="index.html">Home</a>
            <a href="menu.html">Menu</a>
            <a href="about.html">About</a>
            <a href="contact.html">Contact</a>
        </nav>
    </div>
    <div class="container">
            <div class="products">
            <h2>Four-M Menu</h2>
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
            <div class="product" data-id="<?php echo $row['id']; ?>">
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                <h4><?php echo $row['name']; ?></h4>
                <p>₱<?php echo $row['price']; ?></p>
                <?php 
                                    if ($row["stock"] == 0) {
                                        echo '<span class="no-stock">Not Available </span>';
                                    } elseif ($row["stock"] < 10) {
                                        echo '<span class="low-stock-warning">Limited Stock:</span>';
                                        echo '<span class="quantity">' . "&nbsp;" . $row["stock"] . '</span>';
                                    } else {
                                        echo '<span class="stock">Stock: </span>';
                                        echo $row["stock"];
                                    }
                                    ?>
                <div class="quantity-controls">
                    <button onclick="decreaseQuantity(<?php echo $row['id']; ?>)">-</button>
                    <span id="quantity_value_<?php echo $row['id']; ?>">0</span>
                    <button onclick="increaseQuantity(<?php echo $row['id']; ?>, <?php echo $row['stock']; ?>)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', <?php echo $row['price']; ?>, <?php echo $row['stock']; ?>)">Add to Cart</button>
            </div>
            <?php endwhile; ?>
        </div>

                <div class="cart">
            <h3>Your Cart</h3>
            <div id="cartSummary"></div>
            <p id="totalCost">Total: ₱0.00</p>
            <form method="post" action="process_order.php" id="orderForm" onsubmit="return submitOrder()">
                <input type="submit" class="place-order" value="Place Order">
            </form>
        </div>
    </div>
</body>
</html>
