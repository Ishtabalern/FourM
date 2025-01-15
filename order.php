<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Products</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            background-image: url(img/bg.jpg);
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color:rgb(238, 113, 68);
            color: #fff;
            position: fixed;
            top: 0;
            width: 100%;
            height: 80px; /* Adjust based on your logo size */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .navbar img {
            width: 80px;
        }

        .navbar nav {
            display: flex;
            gap: 20px;
            margin-right: 50px;
        }

        .navbar nav a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .navbar nav a:hover {
            color: #ffa382;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            margin-top: 200px; /* Adjust to match the height of the navbar */
            padding: 20px;
            background-color: #ffa382;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
        }
        
        h3 {
            color: #333;
        }
        h2 {
            font-family: berlin, courier;
            font-size: 100px;
            font-weight: 1000;
            color: #fff;
            -webkit-text-stroke: 3px;
            -webkit-text-stroke-color: rgb(235, 100, 77);
            margin-bottom: 10px;
            margin-top: 5px;
            text-align: center;
        }
        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 70%;
        }
        .product {
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 10px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product img {
            max-width: 220px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .product label {
            text-align: center;
            width: 100%;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px 0;
        }
        .quantity-controls button {
            padding: 5px 10px;
            background-color: #e36e5a;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .quantity-controls button:hover {
            background-color: #ed543a;
        }
        .quantity-controls span {
            margin: 0 10px;
            font-size: 16px;
            width: 30px;
            text-align: center;
        }
        button.add-to-cart {
            padding: 5px 10px;
            background-color: #6d3a37;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button.add-to-cart:hover {
            background-color: #5c221e;
        }
        .cart {
            width: 25%;
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
        }
        .cart-item button {
            padding: 5px 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .cart-item button:hover {
            background-color: #c82333;
        }
        #totalCost {
            margin-top: 10px;
            font-weight: bold;
        }
        .place-order {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6d3a37;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .place-order:hover {
            background-color: #5c221e;
        }
        .top {
            text-align: center;
            margin-top: 0;
            padding: 1pt;
            border: 0px;
            margin-bottom: 160px;
        }
        .top img {
            position: absolute;
            margin-top: -25px;
            margin-left: -120px;
            width: 200px;
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
            document.getElementById('totalCost').innerText = `Total Cost: ₱${calculateTotal()}`;
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
    <!-- Navbar -->
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
            <h2></h2>
            <h2>Menu</h2>
            <h2></h2>
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
            <div class="product" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-price="<?php echo $row['price']; ?>">
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                <label>
                    <?php echo $row['name']; ?> - ₱<?php echo $row['price']; ?> 
                    <div class="quantity-controls">
                        <button type="button" onclick="decreaseQuantity(<?php echo $row['id']; ?>)">-</button>
                        <span id="quantity_value_<?php echo $row['id']; ?>">0</span>
                        <button type="button" onclick="increaseQuantity(<?php echo $row['id']; ?>, <?php echo $row['stock']; ?>)">+</button>
                    </div>
                    <button type="button" class="add-to-cart" onclick="addToCart(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', <?php echo $row['price']; ?>, <?php echo $row['stock']; ?>)">Add to Cart</button>
                </label>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="cart">
            <h3>Your Cart</h3>
            <div id="cartSummary"></div>
            <p id="totalCost">Total Cost: ₱0.00</p>
            <form method="post" action="process_order.php" id="orderForm" onsubmit="return submitOrder()">
                <input type="submit" class="place-order" value="Place Order">
            </form>
        </div>
    </div>
</body>
</html>
