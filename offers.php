<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Outer Clove</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <!-- header -->
    <?php
include 'components/header.php';
?>

    <section class="offers-section">
        <div class="offers-container">
            <h1>Special Offers</h1>

            <!-- New Offer Cards -->
            <div class="offer-card">
                <img src="images/weekendoffer.png" alt="Offer 3">
                <h2>Weekend Brunch Special</h2>
                <p>Enjoy a special brunch menu available only on weekends...</p>
            </div>

            <div class="offer-card">
                <img src="images/happyoffer.png" alt="Offer 4">
                <h2>Happy Hour Discounts</h2>
                <p>Discounted drinks and appetizers available during happy hours...</p>
            </div>

            <div class="offer-card">
                <img src="images/chefoffer.png" alt="Offer 5">
                <h2>Seasonal Chef's Special</h2>
                <p>Experience our chef's special seasonal dishes...</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php
include 'components/footer.php';
?>

    <!--Scroll Top  -->
    <a href="#" class="scroll">
        <i class="bx bx-up-arrow-alt"></i>
    </a>

    <!-- link js -->
    <script src="js/script.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
</body>
</html>
