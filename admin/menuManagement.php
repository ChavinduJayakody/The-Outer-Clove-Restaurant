<?php
include('../dbconnection.php');

function createUploadsDirectory()
{
    $uploadsDirectory = "../uploads/";
    if (!file_exists($uploadsDirectory)) {
        mkdir($uploadsDirectory, 0777, true);
    }
}

createUploadsDirectory();

$query = 'SELECT * FROM menu';
$result = $conn->query($query);

if ($result) {
    $menuItems = [];
    while ($row = $result->fetch_assoc()) {
        $menuItems[] = $row;
    }
    $result->free();
}

$cuisinesQuery = 'SELECT * FROM cuisines';
$cuisinesResult = $conn->query($cuisinesQuery);

if ($cuisinesResult) {
    $cuisines = [];
    while ($row = $cuisinesResult->fetch_assoc()) {
        $cuisines[] = $row;
    }
    $cuisinesResult->free();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $cuisine_id = mysqli_real_escape_string($conn, $_POST['cuisine_id']);

    $target_dir = "../uploads/";
    $relativePath = "uploads/" . basename($_FILES["product_image"]["name"]);
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["product_image"]["name"])) . " has been uploaded.";

            $insertQuery = "INSERT INTO menu (item_image_path, item_name, price, cuisine_id)
                            VALUES ('$relativePath', '$item_name', '$price', '$cuisine_id')";

            if ($conn->query($insertQuery) === TRUE) {
                header('Location: menuManagement.php');
                exit();
            } else {
                echo 'Error: ' . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product'])) {
    $id_to_remove = mysqli_real_escape_string($conn, $_POST['remove_product']);

    $deleteQuery = "DELETE FROM menu WHERE id = $id_to_remove";

    if ($conn->query($deleteQuery) === TRUE) {
        header('Location: menuManagement.php');
        exit();
    } else {
        echo 'Error: ' . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_cuisine'])) {
    $id_to_remove = mysqli_real_escape_string($conn, $_POST['remove_cuisine']);

    $deleteQuery = "DELETE FROM cuisines WHERE id = $id_to_remove";

    if ($conn->query($deleteQuery) === TRUE) {
        header('Location: menuManagement.php');
        exit();
    } else {
        echo 'Error: ' . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cuisine'])) {
    $cuisine_id = mysqli_real_escape_string($conn, $_POST['cuisine_id']);
    $cuisine_name = mysqli_real_escape_string($conn, $_POST['cuisine_name']);

    $updateQuery = "UPDATE cuisines SET name = '$cuisine_name' WHERE id = $cuisine_id";

    if ($conn->query($updateQuery) === TRUE) {
        header('Location: menuManagement.php');
        exit();
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outer Clove | Menu Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <header>
        <a href="#" class="logo">
            <img src="../Images/logo (1).png">
        </a>
        <ul class="navlist">
            <li id="welcome-message">Welcome, ADMIN</li>
            <li><a href="admin.php">Reservation Management</a></li>
            <li><a href="#" class="active">Menu Management</a></li>
            <li><a href="reviewManagement.php">Reviews</a></li>
            <li><a href="../login.php">Log Out</a></li>
        </ul>
    </header>

    <section class="admin-dashboard">

        <!-- Cuisines Section -->
        <h2>Cuisine Management</h2>
        <div class="container ">
            <h3>Cuisines :</h3>
            <form method="POST" action="../components/add-cuisine.php" style="margin-top: 20px; margin-left: 30px;">
                <label for="cuisine_name">Add New Cuisine:</label>
                <input type="text" id="cuisine_name" name="cuisine_name" required>
                <button type="submit">Add Cuisine</button>
            </form>

            <h3>Existing cuisines :</h3>
            <div >
                <ul>
                    <?php
                    foreach ($cuisines as $cuisine) {
                        echo "<li class='cuisine-item'>";
                        echo htmlspecialchars($cuisine['name']);
                        echo "<form method='post' class='button-group' style='padding-right 20px; margin-left: 20px;'>";
                        echo "<input type='hidden' name='cuisine_id' value='{$cuisine['id']}'>";
                        echo "<button type='submit' class='update-button' ' name='update_cuisine' ><i class='fas fa-edit'></i> Update</button>";
                        echo "<button type='submit'  class='delete-button' name='remove_cuisine'><i class='fas fa-trash'></i> Remove</button>";
                        echo "</form>";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- Menu Section -->
        <h2>Cuisine Management</h2>
        <div class="container">
            <h3>Menu</h3>
            <form method="post" enctype="multipart/form-data">
                <label for="addproduct_image">Product Image:</label>
                <input type="file" id="addproduct_image" name="product_image" accept="image/*" required>
                <label for="item_name">Product Name:</label>
                <input type="text" name="item_name" required>
                <label for="price">Price:</label>
                <input type="text" name="price" required>
                <label for="cuisine">Cuisine:</label>
                <select name="cuisine_id" id="cuisine">
                    <?php
                    foreach ($cuisines as $cuisine) {
                        echo "<option value='{$cuisine['id']}'>" . htmlspecialchars($cuisine['name']) . "</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="add_product"><i class="fas fa-plus"></i> Add Product</button>
            </form>

            <div id="menu-list">
                <h3>Menu Items</h3>
                <ul>
                    <?php
                    foreach ($menuItems as $menuItem) {
                        echo "<li>";
                        echo "<div class='menu-card'>";
                        echo "<img src='../{$menuItem['item_image_path']}' alt='{$menuItem['item_name']}'>";
                        echo "<div class='menu-card-content'>";
                        echo "<h4>{$menuItem['item_name']}</h4>";
                        echo "<p>Price: {$menuItem['price']}</p>";
                        echo "<form method='post'><input type='hidden' name='remove_product' value='{$menuItem['id']}'><button type='submit'><i class='fas fa-trash'></i> Remove</button></form>";
                        echo "</div>";
                        echo "</div>";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </section>
</body>

</html>