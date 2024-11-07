<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Success</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="reservation-success">
        <div class="container">
            <h2>Reservation Successful!</h2>
            <p>Thank you for your reservation. Your reservation number is <?php echo htmlspecialchars($_GET['reservation_number']); ?>.</p>
            <a href="user.html">Return to Home</a>
        </div>
    </section>

    <script src="script.js"></script>
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
    </script>
    
</body>
</html>
