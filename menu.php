<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_image_path = $_POST["item_image_path"]; 
    $item_name = $_POST["item_name"];
    $price = $_POST["price"];

    $item_image_path = htmlspecialchars($item_image_path);
    $item_name = htmlspecialchars($item_name);
    $price = floatval($price);

    $stmt = $conn->prepare("INSERT INTO menu (item_image_path, item_name, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $item_image_path, $item_name, $price);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query("SELECT * FROM menu");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Outer Clove Restaurant</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
    function toggleCartPopup() {
        var cartPopup = document.getElementById('cart-popup');
        cartPopup.classList.toggle('show');
    }

    function openCartPopup(itemName, itemPrice) {
    var cartItem = {
        name: itemName,
        price: parseFloat(itemPrice),
    };

    cartItemsArray.push(cartItem);
    totalCartPrice += cartItem.price;

    updateCartUI();

    document.getElementById("cart-popup").style.display = "block";
}

    function openCartPopup(itemName, itemPrice) {
        var cartItems = document.getElementById('cart-items');
        var cartTotal = document.getElementById('cart-total');
        
        var cartItem = document.createElement('div');
        cartItem.innerHTML = '<p>' + itemName + ' - Rs.' + itemPrice + '</p>';
        
        cartItems.appendChild(cartItem);

        var currentTotal = parseFloat(cartTotal.innerText.replace('Rs. ', ''));
        var newTotal = currentTotal + parseFloat(itemPrice);
        cartTotal.innerText = 'Rs. ' + newTotal.toFixed(2);

        toggleCartPopup();
    }
    function updateCartUI() {
    var cartContent = document.getElementById("cart-content");
    cartContent.innerHTML = ""; 

    cartItemsArray.forEach(function (cartItem) {
        var cartItemElement = document.createElement("div");
        cartItemElement.className = "cart-item";
        cartItemElement.innerHTML =
            '<p class="item-name">' +
            cartItem.name +
            '</p><p class="item-price">Rs.' +
            cartItem.price.toFixed(2) +
            "</p>";
        cartContent.appendChild(cartItemElement);
    });

    var cartTotal = document.getElementById("cart-total");
    cartTotal.innerText = 'Rs. ' + totalCartPrice.toFixed(2);
}
    function checkout() {
        window.location.href = 'checkout.php';
    }
</script>
</head>
<body>
    <!-- Search -->
<div id="search-popup" class="search-popup">
        <div class="search-content">
            <input type="text" id="searchInput" placeholder="Search...">
            <button onclick="closeSearchPopup()">X</button>
        </div>
    </div>


  <!-- header -->
<section>
    <header>
        <a href="#" class="logo">
        <img src="Images/logo (1).png">
        </a>

        <ul class="navlist">
            <li><a href="user.html">Home</a></li>
            <li><a href="menu.html" class="active">Menu</a></li>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="#footer">Contact Us</a></li>
        </ul>

        <div class="nav-icons">
            <a href="#" onclick="toggleSearchPopup()"><i class="bx bx-search"></i></a>
            <a href="#" onclick="toggleCartPopup()"><i class="bx bx-cart"></i></a>
            <a href="login.php"><i class="bx bx-user" id="user"></i></a>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header> 
</section>




<!-- Menu -->

<section class="shop" id="shop">
        <div class="middle-text">
            <h4>Outer Clove Exclusives</h4>
            <h2>Most Trending Dishes</h2>
        </div>

        <div class="shop-content">
            <?php

    while ($row = $result->fetch_assoc()) {
        echo '<div class="row">';
        echo '<img src="' . $row["item_image_path"] . '" alt="' . $row["item_name"] . '">';
        echo '<h3>' . $row["item_name"] . '</h3>';
        echo '<div class="in-text">';
        echo '<div class="price">';
        echo '<h6>Rs.' . number_format($row["price"], 2) . '</h6>';
        echo '</div>';
        echo '<div class="order-btn">';
        echo '<a href="#" onclick="openCartPopup(\'' . $row["item_name"] . '\', \'' . number_format($row["price"], 2) . '\')">Order Now</a>';
        echo '</div>';
        echo '</div>';
        echo '<div class="top-icon">';
        echo '<a href="#"><i class="bx bx-heart"></i></a>';
        echo '</div>';
        echo '</div>';
}            ?>


<!--  cart -->
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

<!-- Footer -->
<footer id="footer">
    <div class="footer-content">
        <div class="col">
            <img src="Images/logo.png" alt="logo" class="footer-logo">
            <p>Savor the Moment, Taste the Difference – Outer Clove,<br> Where Culinary Excellence Meets Casual Elegance.</p>
        </div>
        <div class="col">
            <h3>Office <div class="underline"><span></span></div></h3>
            <p>123 Flower Road, Piliyandala</p>
            <p class="email-id">contact@outerclove.com</p>
            <h4>+94 777 9696 45</h4>
        </div>
        <div class="col">
            <h3>Branch 2 <div class="underline"><span></span></div></h3>
            <p>456 New York City</p>
            <p class="email-id">contact@outerclovebranch2.com</p>
            <h4>+1 123 456 7890</h4>
        </div>
        <div class="col">
            <ul class="footer-list">
                <h3>Links <div class="underline"><span></span></div></h3>
                <li><a href="#banner">Home</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="reservation.html">Reservations</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact">Contact Us</a></li>
            </ul>
        </div>
     
        <div class="col social-icons-container">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <hr>
    <p class="copyright"> © Chavindu Jayakody 2023- All Rights Reserved </p>
</footer>

<script src="js/script.js"></script>

<script src="https://unpkg.com/scrollreveal"></script>
<script>
    function toggleSearchPopup() {
    var searchPopup = document.getElementById('search-popup');
    searchPopup.style.display = searchPopup.style.display === 'block' ? 'none' : 'block';
}
function searchMenuItems() {
        var searchText = document.getElementById('searchInput').value.toLowerCase();

        var menuItems = document.getElementsByClassName('row');

        for (var i = 0; i < menuItems.length; i++) {
            var itemName = menuItems[i].getElementsByTagName('h3')[0].innerText.toLowerCase();

            if (itemName.includes(searchText)) {
                menuItems[i].style.display = 'block';
            } else {
                menuItems[i].style.display = 'none';
            }
        }
    }

function closeSearchPopup() {
    document.getElementById('search-popup').style.display = 'none';
}
document.getElementById('searchInput').addEventListener('input', searchMenuItems);
</script>

</body>
</html>