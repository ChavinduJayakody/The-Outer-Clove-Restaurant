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


</head>

<body>

    <!-- header -->
    <?php
    include 'components/header.php';
    ?>

    <!-- Reservation -->
    <section class="reservation">
        <div id="reservation" class="reservations-main pad-top-100 pad-bottom-100">
            <div class="container">
                <div class="row">
                    <div class="form-reservations-box">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                                <h2 class="block-title text-center">
                                    Make A
                                </h2>
                            </div>
                            <h4 class="form-title">Reservation</h4>
                            <p>Reserve a day to enjoy the moment. THANKS!</p>

                            <form id="contact-form" method="post" class="reservations-box" name="contactform" action="reservations.php">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-box">
                                        <input type="text" name="name" id="form_name" placeholder="Name" required="required" data-error="Name is required.">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-box">
                                        <input type="email" name="email" id="email" placeholder="E-Mail ID" required data-error="E-mail id is required.">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-box">
                                        <input type="text" name="phone" id="phone" placeholder="contact no.">
                                    </div>
                                </div>


                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-box">
                                        <select name="no_of_persons" id="no_of_persons" class="selectpicker">
                                            <option selected disabled>No. Of persons</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10+</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="col"> -->
                                <div class="form-box">
                                    <input type="date" name="date-picker" id="date-picker" placeholder="Date" required="required" data-error="Date is required." />
                                </div>
                        </div>

                        <!-- <div class="col"> -->
                        <div class="form-box">
                            <input type="time" name="time-picker" id="time-picker" placeholder="Time" required="required" data-error="Time is required." />
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-box">
                            <select name="dietary_preferences" id="dietary_preferences" class="selectpicker">
                                <option selected disabled>Dietary Preferences</option>
                                <option>Vegetarian</option>
                                <option>Non Vegetarian</option>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="col"> -->
                    <div class="reserve-book-btn text-center">
                        <button class="hvr-underline-from-center" type="submit" value="SEND" id="submit">BOOK MY TABLE </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>



    <?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'outerclove-database';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
        $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '';
        $no_of_persons = isset($_POST['no_of_persons']) ? ($_POST['no_of_persons'] === '10+' ? '10+' : (int)$_POST['no_of_persons']) : '';
        $reservation_date = isset($_POST['date-picker']) ? mysqli_real_escape_string($conn, $_POST['date-picker']) : '';
        $reservation_time = isset($_POST['time-picker']) ? mysqli_real_escape_string($conn, $_POST['time-picker']) : '';
        $dietary_preferences = isset($_POST['dietary_preferences']) ? mysqli_real_escape_string($conn, $_POST['dietary_preferences']) : '';

        $sql = "INSERT INTO reservations (name, email, phone, no_of_persons, reservation_date, reservation_time, dietary_preferences)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssissss", $name, $email, $phone, $no_of_persons, $reservation_date, $reservation_time, $dietary_preferences);

            if ($stmt->execute()) {
                $reservation_number = $conn->insert_id;

                $conn->close();

                header("Location: success.php?reservation_number=$reservation_number");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error in preparing statement: " . $conn->error;
        }
    }
    ?>
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <div class="success-message">
            Reservation added successfully!
        </div>
    <?php endif; ?>


    <!-- Footer -->
    <?php
    include 'components/footer.php';
    ?>

    <script src="js/script.js"></script>
</body>

</html>