<?php
include('../dbconnection.php');

$userRole = 'staff';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['status'])) {
    $reservationId = $_POST['id'];
    $newStatus = $_POST['status'];

    $updateSql = "UPDATE reservations SET status = '$newStatus' WHERE id = $reservationId";
    if ($conn->query($updateSql) === TRUE) {
        echo "Status updated successfully";
        exit(); 
    } else {
        echo "Error updating status: " . $conn->error;
        exit(); 
    }
}

$sql = "SELECT * FROM reservations";
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

<section>
    <header>
        <a href="#" class="logo">
            <img src="../Images/logo (1).png">
        </a>
        <ul class="navlist">
            <div>
            <li id="welcome-message" style="color:#ff9f0d;text-decoration:underline; text-align:left; font-weight:bold;">Welcome,Staff</li></div>
            <li><a href="#" class="active">Reservation Management</a></li>
            <li><a href="menuManagementStaff.php">Menu Management</a></li>
            <li><a href="reviewManagementstaff.php">Reviews</a></li>
            <li><a href="../login.php">Log Out</a></li>
        </ul>
    </header> 
</section>

<section>
    <h2>Reservation Management</h2>
    <table id="reservationTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>No. of Persons</th>
                <th>Reservation Date</th>
                <th>Reservation Time</th>
                <th>Dietary Preferences</th>
                <?php if ($userRole === 'staff') : ?>
                    <th>Status</th>
                <?php else : ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='row_" . $row['id'] . "'>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['no_of_persons'] . "</td>";
                    echo "<td>" . $row['reservation_date'] . "</td>";
                    echo "<td>" . $row['reservation_time'] . "</td>";
                    echo "<td>" . $row['dietary_preferences'] . "</td>";
                    if ($userRole === 'staff') {
                        echo "<td id='status_" . $row['id'] . "'>" . $row['status'] . "</td>";
                    } else {
                        echo "<td><button onclick='acceptReservation(" . $row['id'] . ")'>Accept</button> <button onclick='declineReservation(" . $row['id'] . ")'>Decline</button></td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No reservations found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<script src="js/script.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>

<script>
function acceptReservation(reservationId) {
    updateReservationStatus(reservationId, 'accepted');
}

function declineReservation(reservationId) {
    updateReservationStatus(reservationId, 'declined');
}

function updateReservationStatus(reservationId, newStatus) {
    document.getElementById("status_" + reservationId).innerHTML = newStatus;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                console.log(xhr.responseText);
                if (newStatus === 'declined') {
                    var row = document.getElementById("row_" + reservationId);
                    row.parentNode.removeChild(row);
                }
            } else {
                console.error("Error updating status: " + xhr.status);
            }
        }
    };
    xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + reservationId + "&status=" + newStatus);
}
</script>

</body>
</html>
<?php
$conn->close();
?>