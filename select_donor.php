<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'practice');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get request ID and donor ID from the AJAX request
$requestId = $_GET['requestId'];
$donorId = $_GET['donorId'];

// Update the is_selected field in the donor_acceptance table
$sql = "UPDATE donor_acceptance SET is_selected = 'yes' WHERE requestId = '$requestId' AND donor_ID = '$donorId'";

if ($conn->query($sql) === TRUE) {
    echo "Donor selected successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
