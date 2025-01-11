<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_image_path = htmlspecialchars($_POST["item_image_path"]);
    $item_name = htmlspecialchars($_POST["item_name"]);
    $price = floatval($_POST["price"]);

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
    <title>Menu | Outer Clove</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        function toggleCartPopup() {
            document.getElementById('cart-popup').classList.toggle('show');
        }

        function openCartPopup(itemName, itemPrice) {
            var cartItems = document.getElementById('cart-items');
            var cartTotal = document.getElementById('cart-total');
            var cartItem = document.createElement('div');
            cartItem.innerHTML = `<p>${itemName} - Rs.${itemPrice}</p>`;
            cartItems.appendChild(cartItem);

            var currentTotal = parseFloat(cartTotal.innerText.replace('Rs. ', ''));
            var newTotal = currentTotal + parseFloat(itemPrice);
            cartTotal.innerText = `Rs. ${newTotal.toFixed(2)}`;

            toggleCartPopup();
        }

        function updateCartUI() {
            var cartContent = document.getElementById("cart-content");
            cartContent.innerHTML = "";

            cartItemsArray.forEach(function(cartItem) {
                var cartItemElement = document.createElement("div");
                cartItemElement.className = "cart-item";
                cartItemElement.innerHTML = `<p class="item-name">${cartItem.name}</p><p class="item-price">Rs.${cartItem.price.toFixed(2)}</p>`;
                cartContent.appendChild(cartItemElement);
            });

            document.getElementById("cart-total").innerText = `Rs. ${totalCartPrice.toFixed(2)}`;
        }

        function checkout() {
            window.location.href = 'checkout.php';
        }

        function toggleSearchPopup() {
            var searchPopup = document.getElementById('search-popup');
            searchPopup.style.display = searchPopup.style.display === 'block' ? 'none' : 'block';
        }

        function searchMenuItems() {
            var searchText = document.getElementById('searchInput').value.toLowerCase();
            var menuItems = document.getElementsByClassName('row');

            Array.from(menuItems).forEach(function(item) {
                var itemName = item.getElementsByTagName('h3')[0].innerText.toLowerCase();
                item.style.display = itemName.includes(searchText) ? 'block' : 'none';
            });
        }

        function closeSearchPopup() {
            document.getElementById('search-popup').style.display = 'none';
        }

        document.getElementById('searchInput').addEventListener('input', searchMenuItems);
    </script>
</head>

<body>
    <!-- Search Popup -->
    <div id="search-popup" class="search-popup">
        <div class="search-content">
            <input type="text" id="searchInput" placeholder="Search...">
            <button onclick="closeSearchPopup()">X</button>
        </div>
    </div>

    <!-- Header -->
    <?php include 'components/header.php'; ?>

    <!-- Top Image -->
    <div class="top-image">
        <img src="images/gal5.jpg" alt="food">
        <div class="top-text middle-text">
            <h4>The Outer Clove Exclusives</h4>
            <h2>Most Trending Dishes</h2>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="row1">
        <ol class="breadcrumb">
            <li><a href="../index.php" title="The Outer Clove" class="bolds">Home</a></li>
            <li><a href="#">Menu</a></li>
        </ol>
        <div class="search-icon">
            <button onclick="toggleSearchPopup()"><i class="bx bx-search"></i></button>
        </div>
    </div>

    <!-- Menu Section -->
    <section class="shop" id="shop">
        <div class="shop-content">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="row">
                    <img src="<?= $row['item_image_path'] ?>" alt="<?= $row['item_name'] ?>">
                    <h3><?= $row['item_name'] ?></h3>
                    <div class="in-text">
                        <div class="price">
                            <h6>Rs.<?= number_format($row['price'], 2) ?></h6>
                        </div>
                        <div class="order-btn">
                            <a href="#" onclick="openCartPopup('<?= $row['item_name'] ?>', '<?= number_format($row['price'], 2) ?>')">Order Now</a>
                        </div>
                    </div>
                    <div class="top-icon">
                        <a href="#"><i class="bx bx-heart"></i></a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Cart Component -->
    <?php include 'components/cart.php'; ?>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>
