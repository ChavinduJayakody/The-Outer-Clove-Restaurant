<div id="cart-popup" class="cart-popup">
        <div id="cart-header">
            <span class="close-btn" onclick="closeCartPopup()">&times;</span>
            <h2>Your Shopping Cart</h2>
        </div>
        <div id="cart-content">
            <?php
            $cartItemsArray = isset($_SESSION['cartItems']) ? $_SESSION['cartItems'] : array();
            foreach ($cartItemsArray as $cartItem) {
                echo '<div class="cart-item">';
                echo '<p class="item-name">' . htmlspecialchars($cartItem['name']) . '</p>';
                echo '<p class="item-price">Rs. ' . number_format($cartItem['price'], 2) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
        <div id="cart-total-container">
            <p>Total:</p>
            <?php
            $totalCartPrice = isset($_SESSION['totalCartPrice']) ? $_SESSION['totalCartPrice'] : 0;
            echo '<p id="cart-total">Rs. ' . number_format($totalCartPrice, 2) . '</p>';
            ?>
        </div>
        <div id="cart-buttons">
            <button onclick="checkout()">Checkout</button>
            <button onclick="clearCart()">Clear Cart</button>
        </div>
    </div>
    <script>
        var cartItemsArray = [];
        var totalCartPrice = 0;

        function openCartPopup(itemName, itemPrice) {

            itemPrice = itemPrice.replace(',', '');

            var cartItem = {
                name: itemName,
                price: parseFloat(itemPrice),
            };

            cartItemsArray.push(cartItem);
            totalCartPrice += cartItem.price;

            sessionStorage.setItem('cartItems', JSON.stringify(cartItemsArray));
            sessionStorage.setItem('totalCartPrice', totalCartPrice);

            updateCartUI();

            document.getElementById("cart-popup").style.display = "block";
        }

        function closeCartPopup() {
            document.getElementById("cart-popup").style.display = "none";
        }

        function checkout() {
            var checkoutUrl = 'checkout.php?items=' + encodeURIComponent(JSON.stringify(cartItemsArray)) +
                '&total=' + encodeURIComponent(totalCartPrice.toFixed(2));
            window.location.href = checkoutUrl;
        }

        function clearCart() {
            cartItemsArray = [];
            totalCartPrice = 0;

            updateCartUI();
            closeCartPopup();
        }
    </script>
