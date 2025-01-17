<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_image_path = htmlspecialchars($_POST["item_image_path"]);
    $item_name = htmlspecialchars($_POST["item_name"]);
    $price = floatval($_POST["price"]);
    $cuisine_id = intval($_POST["cuisine_id"]);

    $stmt = $conn->prepare("INSERT INTO menu (item_image_path, item_name, price, cuisine_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $item_image_path, $item_name, $price, $cuisine_id);
    $stmt->execute();
    $stmt->close();
}

$cuisines_query = $conn->query("SELECT m.*, c.name AS cuisine_name 
                        FROM menu m 
                        JOIN cuisines c ON m.cuisine_id = c.id 
                        ORDER BY c.name, m.item_name");

if(!$cuisines_query) {
    echo 'Database query failed: ' . $conn->error;
    exit();
}
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

// Search for menu items
function searchMenuItems() {
    var searchText = document.getElementById('searchInput').value.toLowerCase();
    var menuItems = document.getElementsByClassName('row');

    // Filter menu items based on search input
    Array.from(menuItems).forEach(function(item) {
        var itemName = item.getElementsByTagName('h3')[0].innerText.toLowerCase();
        item.style.display = itemName.includes(searchText) ? 'block' : 'none';
    });

    // Show or hide the close icon based on the input length
    var closeIcon = document.getElementById('closeIcon');
    closeIcon.style.display = searchText.length > 0 ? 'block' : 'none';
}

// Clear the search input
function clearSearch() {
    var searchInput = document.getElementById('searchInput');
    searchInput.value = '';
    input.focus();
    // document.getElementById('closeIcon').style.display = 'none';

    // Reset the display of all menu items
    var menuItems = document.getElementsByClassName('row');
    Array.from(menuItems).forEach(function(item) {
        item.style.display = 'block';
    });
}
  </script>
</head>

<body>
    <!-- Search Popup
    <div id="search-popup" class="search-popup">
        <div class="search-content">
            <input type="text" id="searchInput" placeholder="Search...">
            <button onclick="closeSearchPopup()">X</button>
        </div>
    </div> -->

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
        <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search...">
    <i class="bx bx-x close-icon" id="closeIcon" onclick="clearSearch()"></i>
</div>
    </div>

    <!-- Menu Section -->
    <section class="shop" id="shop">
    <div class="shop-content">
        <?php
        // Fetch meals grouped by cuisine
        $current_cuisine = null;
        $has_products = true;
        if (!$has_products) {
            echo "<p>No products found.</p>";
        }

        while ($row = $cuisines_query->fetch_assoc()) {
            if ($current_cuisine !== $row['cuisine_name']) {
                if ($current_cuisine !== null) {
                    // Close the previous cuisine section
                    echo "</div>";
                }
                // Start a new cuisine section
                $current_cuisine = $row['cuisine_name'];
                echo "<h2>" . htmlspecialchars($current_cuisine) . "</h2><div class='cuisine-section'>";
            }
            ?>
            <div class="row">
                <img src="<?= htmlspecialchars($row['item_image_path']) ?>" alt="<?= htmlspecialchars($row['item_name']) ?>">
                <h3><?= htmlspecialchars($row['item_name']) ?></h3>
                <div class="in-text">
                    <div class="price">
                        <h6>Rs.<?= number_format($row['price'], 2) ?></h6>
                    </div>
                    <div class="order-btn">
                        <a href="#" onclick="openCartPopup('<?= htmlspecialchars($row['item_name']) ?>', '<?= number_format($row['price'], 2) ?>')">Order Now</a>
                    </div>
                </div>
                <div class="top-icon">
                    <a href="#"><i class="bx bx-heart"></i></a>
                </div>
            </div>
            <?php
        }
        if ($current_cuisine !== null) {
            // Close the last cuisine section
            echo "</div>";
        }
        $conn->close();
        ?>
    </div>
</section>
    <!-- Cart Component -->
    <?php include 'components/cart.php'; ?>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>
