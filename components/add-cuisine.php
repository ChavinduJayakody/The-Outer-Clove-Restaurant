<?php
include('../dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cuisine_name = htmlspecialchars($_POST["cuisine_name"]);

    $stmt = $conn->prepare("INSERT INTO cuisines (name) VALUES (?)");
    $stmt->bind_param("s", $cuisine_name);
    $stmt->execute();
    $stmt->close();

    header("Location: ../admin/menuManagement.php"); // Redirect back to menu page
    exit();
}
?>
