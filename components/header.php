<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" type="text/css" href="style.css">
   
   <!-- header -->
    <section>
        <header>
            <a href="#" class="logo">
                <img src="Images/logo (1).png">
            </a>

            <ul class="navlist">
                <li class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">
                    <a href="index.php" >Home</a></li>
                <li class="<?= ($current_page == 'menu.php') ? 'active' : '' ?>">
                    <a href="menu.php">Menu</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="offers.php">Offers</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="#footer">Contact Us</a></li>

                <br>


            </ul>

            <div class="nav-icons">
                <a href="#"><i class="bx bx-cart"></i></a>
                <a href="login.php"><i class="bx bx-user" id="user"></i></a>
                <div class="bx bx-menu" id="menu-icon"></div>
            </div>
        </header>
    </section>
