<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$selectedItemsJSON = $_GET['items'] ?? '[]';
$selectedItems = json_decode(urldecode($selectedItemsJSON), true);

function calculateSubtotal($items) {
    $subtotal = 0;
    foreach ($items as $item) {
        $subtotal += floatval(str_replace('Rs. ', '', $item['price']));
    }
    return number_format($subtotal, 2);
}

function calculateTotal($items) {
    return calculateSubtotal($items);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - The Outer Clove Restaurant</title>

    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="checkout.css">
    
</head>

    <style>
    </style>
</head>
<body>
    <span id="closeIcon" class="close-icon" onclick="closeCheckout()">X</span>


    <div class="container">
        <div class="checkout-form">
            <h2>Checkout</h2>
            <form action="process_checkout.php" method="post">
                <div class="name-row">
                    <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
                    <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
                </div>

                <input type="text" id="street" name="street" placeholder="Street Address" required>
                <input type="text" id="district" name="district" placeholder="District" required>
                <input type="text" id="city" name="city" placeholder="City" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="tel" id="contactNumber" name="contactNumber" placeholder="Contact Number" required>
                <input type="tel" id="contactNumber2" name="contactNumber2" placeholder="Contact Number 2 (Optional)">
                <textarea id="specialNotes" name="specialNotes" placeholder="Special Notes"></textarea>

                <div class="buttons-row">
                <label for="deliveryType">Choose delivery type:</label>
                <select id="deliveryType" name="deliveryType" required>
                    <option value="pickup">Pickup</option>
                    <option value="delivery">Delivery</option>
                </select>
                </div>            
            </form>
            <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include 'connectdb.php';

    $firstName = $_POST['first-name'];



    $productNames = [];
    $productPrices = [];

    foreach ($selectedItems as $item) {
        $productNames[] = $item['name'];
        $productPrices[] = $item['price'];
    }


    $productNameString = implode(", ", $productNames);
    $productPriceString = implode(", ", $productPrices);

    $sql = "INSERT INTO orders (first_name, last_name, street_address, city, email, mobile_number, order_type, order_notes, product_name, product_price)
            VALUES ('$firstName', '$lastName', '$streetAddress', '$city', '$email', '$mobileNumber', '$orderType', '$orderNotes', '$productNameString', '$productPriceString')";

    if ($conn->query($sql) === TRUE) {
        echo "Order submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    $conn->close();
}
?>
        </div>

        <div class="order-summary">
            <h2>Order Summary</h2>

            <div class="item-list">
                <?php
                $itemsJSON = $_GET['items'] ?? '[]';
                $total = $_GET['total'] ?? '0.00';

                $items = json_decode(urldecode($itemsJSON), true);

                foreach ($items as $item) {
                    echo '<div>';
                    echo '<span>' . htmlspecialchars($item['name']) . '</span>';
                    echo '<span>Rs. ' . number_format($item['price'], 2) . '</span>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class="total-row">
                <span>Total:</span>
                <span>Rs. <?php echo number_format($total, 2); ?></span>
            </div>


            <button id="placeOrderBtn" type="submit" onclick="placeOrder()">Place Order</button>
        </div>
    </div>

    <script>

        function placeOrder() {
            alert("Placed Order Successfully. Thank You for choosing us");
            window.location.href = 'menu.php';
        }
        function closeCheckout() {
    document.getElementById('closeIcon').style.display = 'none';
    window.location.href = 'menu.php';
}

    </script>
    
</body>    


</html>