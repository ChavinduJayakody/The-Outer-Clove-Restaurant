<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'dbconnection.php';

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = intval($_POST['rating']);
    $description = $_POST['description'];

    $sql = "INSERT INTO reviews (name, email, rating, description) VALUES ('$name', '$email', '$rating', '$description')";

    if ($conn->query($sql) === TRUE) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
