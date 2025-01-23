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
    $description = mysqli_real_escape_string($conn, $_POST['description']);

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
                            VALUES ('$relativePath', '$item_name', '$price', '$cuisine_id', '$description')";

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
            <div>
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
        <h2>Menu Management</h2>
        <div class="container menu-container">
            <div>
                <h3>Menu :</h3>
            </div>
            <div class="form-container">
                <form method="post" enctype="multipart/form-data" class="form-left">
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
                    <label for="description">Description:</label>
                    <input type="text" name="description" placeholder="Description" required>

                    <button type="submit" name="add_product"><i class="fas fa-plus"></i> Add Product</button>
                </form>

                <div class="image-upload-container">
                    <label for="addproduct_image" class="image-upload-box">
                        <div class="placeholder">
                            <i class="fas fa-plus"></i>
                            <p class="upload-hint">Only image formats (JPG, PNG, GIF) are allowed</p>
                        </div>
                        <img id="imagePreview" src="#" alt="Selected Image" style="display: none;" />
                    </label>
                    <input type="file" id="addproduct_image" name="product_image" accept="image/*" onchange="previewImage(event)" required hidden>
                    <div class="image-controls" style="display: none;">
                        <button type="button" class="change-btn" onclick="changeImage()">Change</button>
                        <button type="button" class="remove-btn" onclick="removeImage()">Remove</button>
                    </div>
                </div>
            </div>

            <div>
    <h3>Existing Menu Items:</h3>
    <ul class="menu-list">
        <?php
        foreach ($menuItems as $menuItem) {
            // Retrieve the cuisine name for each menu item
            $cuisineName = "";
            foreach ($cuisines as $cuisine) {
                if ($cuisine['id'] === $menuItem['cuisine_id']) {
                    $cuisineName = $cuisine['name'];
                    break;
                }
            }
            
            echo "<li class='menu-list-item'>";
            echo "<img src='../{$menuItem['item_image_path']}' alt='{$menuItem['item_name']}' class='menu-item-image'>";
            echo "<div class='menu-item-info'>";
            echo "<h4 class='menu-item-name'>{$menuItem['item_name']}</h4>";
            echo "<p class='menu-item-cuisine'>Cuisine: {$cuisineName}</p>";
            echo "<p class='menu-item-description'>Description: {$menuItem['description']}</p>"; 
            echo "<p class='menu-item-price'>Price: {$menuItem['price']}</p>";
            echo "</div>";
            echo "<div class='menu-item-actions'>";
            echo "<form method='post' class='action-form'>";
            echo "<input type='hidden' name='remove_product' value='{$menuItem['id']}'>";
            echo "<button type='submit' class='action-button delete-button'><i class='fas fa-trash'></i> Delete</button>";
            echo "</form>";
            echo "<form method='post' class='action-form'>";
            echo "<input type='hidden' name='update_product' value='{$menuItem['id']}'>";
            echo "<button type='submit' class='action-button update-button'><i class='fas fa-edit'></i> Update</button>";
            echo "</form>";
            echo "</div>";
            echo "</li>";
        }
        ?>
    </ul>
</div>
        </div>
    </section>
</body>

<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const placeholder = document.querySelector('.image-upload-box .placeholder');
        const controls = document.querySelector('.image-controls');

        // Show the preview
        const reader = new FileReader();
        reader.onload = () => {
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
            placeholder.style.opacity = '0';
            controls.style.display = 'flex'; // Show the buttons
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function changeImage() {
        // Trigger the file input click event
        document.getElementById('addproduct_image').click();
    }

    function removeImage() {
        const imagePreview = document.getElementById('imagePreview');
        const placeholder = document.querySelector('.image-upload-box .placeholder');
        const controls = document.querySelector('.image-controls');
        const fileInput = document.getElementById('addproduct_image');

        // Clear the image preview
        imagePreview.src = '#';
        imagePreview.style.display = 'none';
        placeholder.style.opacity = '1';
        controls.style.display = 'none'; // Hide the buttons

        // Clear the file input value
        fileInput.value = '';
    }
</script>

</html>