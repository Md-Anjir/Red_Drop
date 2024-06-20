<?php
// Check if request_id is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['requestId'])) {
    // Process the response here
    $requestId = $_POST['requestId'];

    // Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION['phone'])) {
    header("Location: login_form.html");
    exit;
}

    //$donor_ID = $_POST['donor_ID'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root"; // default username for XAMPP
    $password = ""; // default password for XAMPP (empty)
    $dbname = "practice"; // replace 'your_database_name' with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $phone = $_SESSION['phone'];
    $sql = "SELECT * FROM users WHERE phone='$phone'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        // User found, display user information
        $row = $result->fetch_assoc();
        $donor_ID= $row['user_ID'];
        // You can retrieve other user information here
    } else {
        // User not found
        echo "User not found";
    }

    // SQL query to insert data into the donor_acceptance table
    $sql_insert = "INSERT INTO donor_acceptance (donor_ID, requestId) 
                   VALUES ('$donor_ID', '$requestId')";


if ($conn->query($sql_insert) === TRUE) {
    echo "<script>alert('Response submitted successfully for request ID: $requestId'); window.location.href = 'blood_donation_requests.php';</script>";
}

 else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
