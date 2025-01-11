<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Outer Clove Restaurant</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>


</head>

<body>

<!-- header -->
<?php
include 'components/header.php';
?>

<!-- Main -->
<section id="#home">
    <div class="background-container home" id="home">
        <div class="outer">
            <div class="details">
                <h1 style="align-items:center"> <span>The Outer</span> Clove <br>Restaurant</h1>
                <h2>
                    <span class="hide">Savor the Moment </span>
                    <span class="hide">Taste the Difference</span>
                </h2>
                <div class="book-btn">
                    <a href="menu.php">Taste Now</a>
                </div>
                <a href="#about">
                    <div class="mouse"></div>
                </a>
            </div>
        </div>
    </div>
</section>



<!-- Icons -->
<section class="icon-container">
    <div class="icon-container-box">
        <img src="Images/time.png">
        <h3>11:00 am - 10:00 pm</h3>
        <a href="">Working Hours</a>
    </div>
    <div class="icon-container-box">
        <img src="Images/location.png">
        <h3>123 Dexton Road, Colombo</h3>
        <a href="">Get Directions</a>
    </div>
    <div class="icon-container-box">
        <img src="Images/call.png">
        <h3>+94 112 124 567</h3>
        <a href="">Call Us Now</a>
    </div>
</section>

<!-- About Us -->
<section class="about" id="about">
    <div class="about-img">
        <img src="Images/about.jpg">
    </div>
    <div class="about-text">
        <h2>Savor the Moment. <br>Taste the Difference.</h2>
        <p>
            Discover The Outer Clove in Colombo, where global flavors meet local flair.</br>
            Our restaurant offers a palate-pleasing menu in a stylish,</br>
            welcoming atmosphere. Whether it's brunch or dinner,</br>
            experience memorable dining with each bite as a journey of flavors.</p>
        <a href="about.html" class="book-btn" style="background-color:rgb(146, 26, 64);" >Explore Story <i class="fa-solid fa-play"></i></a>
    </div>
</section>

<!-- special dishes -->
<section class="shop" id="shop">
    <div class="middle-text">
        <h4>The Outer Clove Promotions</h4>
        <h2>Most Trending Dishes</h2>
    </div>

    <div class="shop-content">
        <div class="row">
            <img src="Images/Chicken Biriyani.png">
            <h3> Chicken Biriyani</h3>

            <div class="in-text">
                <div class="price">
                    <h6>Rs.2400.00</h6>
                </div>
                <div class="order-btn">
                    <a href="#">Order Now</a>
                </div>
            </div>

            <div class="top-icon">
                <a href="#"><i class="bx bx-heart"></i></a>
            </div>
        </div>

        <div class="row">
            <img src="Images/burger.png">
            <h3> Chicken Burger</h3>

            <div class="in-text">
                <div class="price">
                    <h6>Rs.2500.00</h6>
                </div>
                <div class="order-btn">
                    <a href="#">Order Now</a>
                </div>
            </div>

            <div class="top-icon">
                <a href="#"><i class="bx bx-heart"></i></a>
            </div>
        </div>

        <div class="row">
            <img src="Images/hotdrumlets.png">
            <h3> Hot Drumlets</h3>

            <div class="in-text">
                <div class="price">
                    <h6>Rs.2800.00</h6>
                </div>
                <div class="order-btn">
                    <a href="#">Order Now</a>
                </div>
            </div>

            <div class="top-icon">
                <a href="#"><i class="bx bx-heart"></i></a>
            </div>
        </div>

        <div class="row">
            <img src="Images/chicken tacos1.png">
            <h3> Regular Meal</h3>

            <div class="in-text">
                <div class="price">
                    <h6>Rs.2990.00</h6>
                </div>
                <div class="order-btn">
                    <a href="#">Order Now</a>
                </div>
            </div>

            <div class="top-icon">
                <a href="#"><i class="bx bx-heart"></i></a>
            </div>
        </div>

    </div>
    <div class="row-btn">
        <a href="menu.php" class="book-btn">All Items <i class="fa-solid fa-play"></i></a>
    </div>
</section>

<section class="review" id="review">
    <div class="review-content">

        <div class="middle-text">
            <h4>Our Customer</h4>
            <h2>Clients Review About Our Food</h2>
        </div>

        <div class="box">
            <p> <i class="fa fa fa-quote-left"></i>The Taste is still in my mouth
                and I can feel the depth of the taste of the taste of the every ingredients used in the food. I
                really love Special Tacos
                <i class="fa fa fa-quote-right"></i>
            </p>
            <div class="in-box">
                <div class="bx-img">
                    <i class="bx bxs-user"></i>
                </div>
                <div class="bxx-text">
                    <h4>Nethmi De Silva</h4>
                    <h5>Food Vlogger</h5>
                    <div class="ratings">
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>

                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <p> <i class="fa fa fa-quote-left"></i>The Taste is still in my mouth
                and I can feel the depth of the taste of the taste of the every ingredients used in the food. I
                really love Special Tacos
                <i class="fa fa fa-quote-right"></i>
            </p>
            <div class="in-box">
                <div class="bx-img">
                    <i class="bx bxs-user"></i>
                </div>
                <div class="bxx-text">
                    <h4>Dinuka Perera</h4>
                    <h5>Food Vlogger</h5>
                    <div class="ratings">
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>

                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <p> <i class="fa fa fa-quote-left"></i>I had an amazing experience at The Outer Clove! The flavors
                were incredibly authentic,
                transporting me straight to the vibrant streets of Sri Lanka. The warm and welcoming ambiance added
                to the overall charm. Highly recommend!
                <i class="fa fa fa-quote-right"></i>
            </p>
            <div class="in-box">
                <div class="bx-img">
                    <i class="bx bxs-user"></i>
                </div>
                <div class="bxx-text">
                    <h4>Ishan Abeyrathna</h4>
                    <h5>Food Vlogger</h5>
                    <div class="ratings">
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>
                        <a href="#"><i class="bx bxs-star"></i></a>

                    </div>
                </div>
            </div>

        </div>
        <div class="row-btn3">
            <button class="book-btn " style="background-color: #ff8c00;" onclick="openModal()">Add Your Review <i
                    class="fa-solid fa-play"></i></button>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="reviewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Add Your Review</h2>
        <form id="reviewForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="rating">Rating:</label>
            <div class="star-rating">
                <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
                <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
                <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
                <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
                <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
            </div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // JavaScript to handle modal
    function openModal() {
        document.getElementById("reviewModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("reviewModal").style.display = "none";
    }

    // Close the modal when clicking outside of the modal content
    window.onclick = function(event) {
        var modal = document.getElementById("reviewModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // form submission
    document.getElementById("reviewForm").addEventListener("submit", function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch('submit-review.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(text => {
                console.log('Raw response:', text);
                return JSON.parse(text);
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Review added successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        closeModal();
                        document.getElementById("reviewForm").reset();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error adding your review',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                // console.error('Error:', error);
                Swal.fire({
                    title: 'Success!',
                    text: 'Review added successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    closeModal();
                    document.getElementById("reviewForm").reset();
                });
            });
    });
</script>

<!-- footer -->
<?php
include 'components/footer.php';
?>




<!-- link js -->
<script src="js/script.js"></script>

<script src="https://unpkg.com/scrollreveal"></script>


</body>

</html>