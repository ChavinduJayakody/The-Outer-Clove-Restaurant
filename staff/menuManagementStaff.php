<?php
include('../dbconnection.php');

function createUploadsDirectory() {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

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
            echo "The file ". htmlspecialchars( basename( $_FILES["product_image"]["name"])). " has been uploaded.";

            $insertQuery = "INSERT INTO menu (item_image_path, item_name, price)
                            VALUES ('$relativePath', '$item_name', '$price')";

            if ($conn->query($insertQuery) === TRUE) {
                header('Location: menuManagementStaff.php');
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
        header('Location: menuManagementStaff.php');
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
    <title>Signature Cuisine - Menu Management</title>
    <link rel="stylesheet" href="../admin.css">
</head>
<body>
    <section>
        <header>
            <a href="#" class="logo">
                <img src="../Images/logo (1).png">
            </a>
            <ul class="navlist">
                <li style="color:#ff9f0d;text-decoration:underline; text-align:left; font-weight:bold;">Welcome,Staff</li>
                <li><a href="staff.php">Reservation Management</a></li>
                <li ><a href="#" class="active">Menu Management</a></li>
                <li><a href="reviewManagementstaff.php">Reviews</a></li>
                <li><a href="../login.php">Log Out</a></li>

            </ul>
        </header>
    </section>
    <section>
        <h2>Menu Management</h2>
        <form method="post" enctype="multipart/form-data" style="margin-top: 20px; text-align:center;">
            <label for="addproduct_image">Product Image:</label>
            <input type="file" id="addproduct_image" name="product_image" accept="image/*" required>
            <label for="item_name">Product Name:</label>
            <input type="text" name="item_name" required>
            <label for="price">Price:</label>
            <input type="text" name="price" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>
        <div id="menu-list" class="menu-grid">
        <?php
        if (isset($menuItems)) {
            foreach ($menuItems as $menuItem) {
                echo "<div class='menu-item'>";
                echo "<img src='../{$menuItem['item_image_path']}' alt='{$menuItem['item_name']}'>";
                echo "<div class='menu-item-content'>";
                echo "<p>{$menuItem['item_name']}</p>";
                echo "<p>Price: {$menuItem['price']}</p>";
                echo "<form method='post'><input type='hidden' name='remove_product' value='{$menuItem['id']}'><button type='submit'>Remove</button></form>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
    </section>
</body>
</html>