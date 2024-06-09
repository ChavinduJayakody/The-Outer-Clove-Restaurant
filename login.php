<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('dbconnection.php');

function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {

                if ($email == "admin@outerclove" && $password == "admin") {
                    echo '<script>alert("Login Successful as admin!");</script>';
                    echo '<script>window.location.href = "admin.php";</script>';
                } elseif ($email == "staff@outerclove" && $password == "staff") {
                    echo '<script>alert("Login Successful as staff!");</script>';
                    echo '<script>window.location.href = "staff.php";</script>';
                } else {
                    echo '<script>alert("Login successful! \u2713");</script>';
                    echo '<script>window.location.href = "user.html";</script>';
                }
            } else {
                echo '<script>alert("Incorrect email or password. Please try again.");</script>';
            }
        } else {
            echo '<script>alert("Incorrect email or password. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Email and password are required.");</script>';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $fullName = sanitizeInput($_POST["fullName"]);
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    if (!empty($fullName) && !empty($email) && !empty($password)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Signup successful! \u2713");</script>';
            echo '<script>window.location.href = "user.html";</script>';
        } else {
            echo '<script>alert("Error in signup. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("All fields are required.");</script>';
    }
}

mysqli_close($conn);
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    

    
</head>
<body>

  <!-- header -->
<section>
    <header>
        <a href="#" class="logo">
        <img src="Images/logo (1).png">
        </a>

        <ul class="navlist">
            <li><a href="index.html" >Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="reservations.php">Reservations</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#footer">Contact Us</a></li>
        </ul>

        <div class="nav-icons">
            <a href="#"><i class="bx bx-cart"></i></a>
            <a href="#login-form"><i class="bx bx-user userbutton " id="user"></i></a>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header> 
</section>

<!-- Login -->

<section class="container forms">
    <div class="form-overlay show-login">
        <div class="form login">
            <div class="form-content login-form">
                <h1>Login</h1>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">                    
                <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" name="email">
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" name="password">
                        <i class="bx bx-hide eye-icon"></i>
                    </div>

                    <div class="form-link">
                    <a href="#" class="forgot-pass">Forgot Password?</a>
                    </div>

                    <div class="field button-field">
                        <button type="submit" name="login">Login</button> 
                    </div>


                </form>
                <div class="form-link">
                        <span>Already have an account? <a href="#" class="signup-link">Signup</a></span>
                    </div>
            </div>

            <div class="line"> </div>

        </div>

<!-- Signup  -->

        <div class="form signup">
            <div class="form-content signup-form">
                <h1>Signup</h1>

          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">                    
          <div class="field input-field">
                        <input type="text" placeholder="Full Name" class="input" name="fullName">
                    </div>

                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" name="email">
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" name="password">
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" name="password">
                        <i class="bx bx-hide eye-icon"></i>
                    </div>

                    <div class="field button-field">
                        <button type="submit" name="signup">Signup</button> 
                    </div>

                </form>
                <div class="form-link">
                        <span>Already have an account? <a href="#" class="login-link">Login</a></span>
                    </div>
            </div>

            <div class="line"> </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const loginLink = document.querySelector('.login-link');
        const signupLink = document.querySelector('.signup-link');
        const formsContainer = document.querySelector('.forms');

        loginLink.addEventListener('click', function (e) {
            e.preventDefault();
            formsContainer.classList.remove('show-signup');
            formsContainer.classList.add('show-login');
        });

        signupLink.addEventListener('click', function (e) {
            e.preventDefault();
            formsContainer.classList.remove('show-login');
            formsContainer.classList.add('show-signup');
        });
    });
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
                <li class="active"><a href="#banner">Home</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="reservation.html">Reservations</a></li>
                <li><a href="#offers">About Us</a></li>
                <li><a href="#contact">Contact Us</a></li>
            </ul>
        </div>
     
        <div class="social">
            <a href="#" class="clr"><i class="bx bxl-instagram-alt"></i></a>
            <a href="#"> <i class="bx bxl-facebook"></i></a>
            <a href="#"><i class="bx bxl-twitter"></i></a>
            <a href="#"><i class="bx bxl-github"></i></a>
            <a href="#"><i class="bx bxl-google"></i></a>
        </div>
</div>
    <hr>
    <p class="copyright">© Chavindu Jayakody 2023- All Rights Reserved</p>
</footer>

<!--Scroll Top  -->
<a href="#" class="scroll">
    <i class="bx bx-up-arrow-alt"></i>
</a>



<script src="js/script.js"></script>

<script src="https://unpkg.com/scrollreveal"></script>


</body>
</html>

