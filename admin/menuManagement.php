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

// add product
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

            $insertQuery = "INSERT INTO menu (item_image_path, item_name, price, cuisine_id, description)
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

    // remove product
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

// update product

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $item_id = mysqli_real_escape_string($conn, $_POST['update_item_id']);
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $cuisine_id = mysqli_real_escape_string($conn, $_POST['cuisine_id']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $updateQuery = "UPDATE menu SET";

    $fieldsToUpdate = [];

    if (!empty($item_name)) {
        $fieldsToUpdate[] = "item_name = '$item_name'";
    }
    if (!empty($price)) {
        $fieldsToUpdate[] = "price = '$price'";
    }
    if (!empty($cuisine_id)) {
        $fieldsToUpdate[] = "cuisine_id = '$cuisine_id'";
    }
    if (!empty($description)) {
        $fieldsToUpdate[] = "description = '$description'";
    }

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        $target_dir = "../uploads/";
        $relativePath = "uploads/" . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1 && move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $fieldsToUpdate[] = "item_image_path = '$relativePath'";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    if (count($fieldsToUpdate) > 0) {
        $updateQuery .= " " . implode(", ", $fieldsToUpdate) . " WHERE id = $item_id";

        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Product Updated!',
                        text: 'The product details were updated successfully.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = 'menuManagement.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was an error updating the product.',
                        showConfirmButton: true
                    });
                  </script>";
        }
    }
}
// remove cuisine
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

// update cuisine
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
            <form method="POST" action="../components/add-cuisine.php" onsubmit="addCuisinePopup(event, document.getElementById('cuisine_name').value)" style="margin-top: 20px; margin-left: 30px;">
                <label for="cuisine_name">Add New Cuisine:</label>
                <input type="text" id="cuisine_name" name="cuisine_name" required>
                <button
                    type="submit"
                    class="action-button add-button"
                    onclick="addCuisinePopup(event, document.getElementById('cuisine_name').value)">Add Cuisine
                </button>
            </form>

            <h3>Existing cuisines :</h3>
            <div>
                <ul>
                    <?php foreach ($cuisines as $cuisine): ?>
                        <li class="cuisine-item">
                            <?= htmlspecialchars($cuisine['name']); ?>
                            <div class="menu-actions">
                                <!-- Update Button -->
                                <button
                                    type="button"
                                    class="action-button update-button"
                                    onclick="event.preventDefault(); showUpdatePopup(event, <?= $cuisine['id']; ?>, '<?= htmlspecialchars($cuisine['name']); ?>')">
                                    <i class="fas fa-edit"></i> Update
                                </button>


                                <!-- Delete Button -->
                                <button
                                    type="button"
                                    class="action-button delete-button"
                                    onclick="showDeleteConfirmation(event, <?= $cuisine['id']; ?>)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <form id="update-form" method="post" style="display: none;">
                <input type="hidden" id="update_cuisine_id" name="cuisine_id">
                <input type="hidden" id="update_cuisine_name" name="cuisine_name">
                <input type="hidden" name="update_cuisine" value="true">
            </form>

            <form id="delete-form" method="post" style="display: none;">
                <input type="hidden" id="delete_cuisine_id" name="remove_cuisine">
            </form>
        </div>
        <!-- Menu Section -->
        <h2>Menu Management</h2>
        <div class="container menu-container">
            <div>
                <h3>Menu :</h3>
            </div>
            <div class="container">
                <form method="post" enctype="multipart/form-data" class="form-container" onsubmit="addProductPopup(event, document.getElementById('item_name').value)">
                    <div class="form-left">
                        <label for="item_name">Product Name:</label>
                        <input type="text" name="item_name" placeholder="Product Name" required>

                        <label for="price">Price:</label>
                        <input type="text" name="price" placeholder="Price" required>

                        <label for="cuisine">Cuisine:</label>
                        <select name="cuisine_id" id="cuisine" placeholder="Select Cuisine" required>
                            <?php
                            foreach ($cuisines as $cuisine) {
                                echo "<option value='{$cuisine['id']}'>" . htmlspecialchars($cuisine['name']) . "</option>";
                            }
                            ?>
                        </select>
                        <label for="description">Description:</label>
                        <input type="text" name="description" placeholder="Description" required>

                        <button type="submit" name="add_product" onclick="addProductPopup(event, document.getElementById('item_name').value)"><i class="fas fa-plus"></i> Add Product</button>
                    </div>



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
            </form>


            <h3>Existing Menu Items:</h3>
            <div class="container">
                <ul class="menu-list">
                    <?php
                    foreach ($menuItems as $menuItem) {

                        $cuisineName = "";
                        foreach ($cuisines as $cuisine) {
                            if ($cuisine['id'] === $menuItem['cuisine_id']) {
                                $cuisineName = $cuisine['name'];
                                break;
                            }
                        }

                        echo "<li class='menu-list-item cuisine-item'>";
                        echo "<img src='../{$menuItem['item_image_path']}' alt='{$menuItem['item_name']}' class='menu-item-image'>";
                        echo "<div class='menu-item-info'>";
                        echo "<h4 class='menu-item-name'>{$menuItem['item_name']}</h4>";
                        echo "<p class='menu-item-cuisine'>Cuisine: {$cuisineName}</p>";
                        echo "<p class='menu-item-description'>Description: {$menuItem['description']}</p>";
                        echo "<p class='menu-item-price'>Price: {$menuItem['price']}</p>";
                        echo "</div>";

                        // Actions
                        echo "<div class='menu-item-actions'>";

                        // Update and delete buttons
                        echo "<form method='post' class='action-form'>";
                        echo "<button type='button' class='action-button update-button' 
                        onclick='openPopup(event, {$menuItem['id']}, \"" . addslashes($menuItem['item_name']) . "\", \"" . addslashes($menuItem['item_image_path']) . "\", \"" . addslashes($menuItem['price']) . "\", \"" . addslashes($menuItem['description']) . "\", {$menuItem['cuisine_id']})'>
                        <i class='fas fa-edit'></i> Update</button>";
                        echo "</form>";
                        echo "<form method='post' class='action-form'>";
                        echo "<input type='hidden' name='delete_product'>";
                        echo "<button type='submit' class='action-button delete-button' onclick='event.preventDefault(); deleteProduct(event, {$menuItem['id']})'>
                        <i class='fas fa-trash'></i> Delete</button>";
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="functions/addCuisine.js"></script>
<script src="functions/addProduct.js"></script>
<script src="functions/updateCuisine.js"></script>
<script src="functions/updateProduct.js"></script>
<script src="functions/deleteCuisine.js"></script>
<script src="functions/deleteProduct.js"></script>


 <!-- Menu update popup -->

<script>

window.cuisinesData = <?php echo json_encode($cuisines); ?>;

</script>

 <!-- product delete popup -->


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
            controls.style.display = 'flex';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function changeImage() {
        document.getElementById('addproduct_image').click();
    }

    function removeImage() {
        const imagePreview = document.getElementById('imagePreview');
        const placeholder = document.querySelector('.image-upload-box .placeholder');
        const controls = document.querySelector('.image-controls');
        const fileInput = document.getElementById('addproduct_image');

        imagePreview.src = '#';
        imagePreview.style.display = 'none';
        placeholder.style.opacity = '1';
        controls.style.display = 'none';

        fileInput.value = '';
    }
</script>

</html>