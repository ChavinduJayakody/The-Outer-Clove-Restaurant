<?php
include('../dbconnection.php');


$sql = "SELECT * FROM reviews";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signature Cuisine</title>
    <link rel="stylesheet" href="../admin.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>

<body>

    <!-- header -->
    <section>
        <header>
            <a href="#" class="logo">
                <img src="../Images/logo (1).png">
            </a>

            <ul class="navlist">
                <div>
                    <li id="welcome-message" style="color:#ff9f0d;text-decoration:underline; text-align:left; font-weight:bold;">Welcome,ADMIN</li>
                </div>
                <li><a href="admin.php">Reservation Management</a></li>
                <li><a href="menuManagement.php">Menu Management</a></li>
                <li><a href="reviewManagement.php" class="active">Reviews</a></li>
                <li><a href="../login.php">Log Out</a></li>

            </ul>
        </header>
    </section>


    <!-- Admin dashboard -->
    <section>
        <h2 style="text-align: center; text-decoration:underline; letter-spacing:2px;">Reviews</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['reg_date']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No reviews found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>


    <script src="js/script.js"></script>

    <script src="https://unpkg.com/scrollreveal"></script>
</body>

</html>
<?php
$conn->close();
?>