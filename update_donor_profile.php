<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION['phone'])) {
    header("Location: login_form.html");
    exit;
}

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

// Retrieve user information
$phone = $_SESSION['phone'];
$sql = "SELECT * FROM users WHERE phone='$phone'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // User found, display user information
    $row = $result->fetch_assoc();
    $user_ID = $row['user_ID'];
    // You can retrieve other user information here
} else {
    // User not found
    echo "User not found";
}

// Check if donor profile exists
$sql_check_profile = "SELECT * FROM donor_profiles WHERE user_ID = '$user_ID'";
$result_check_profile = $conn->query($sql_check_profile);

if ($result_check_profile->num_rows == 1) {
    // Donor profile exists, update the profile
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $location_id = $_POST['location']; // Assuming you're storing location ID in the users table

// Fetch location name based on location ID
$sql_location = "SELECT location_name FROM locations WHERE location_id = '$location_id'";
$result_location = $conn->query($sql_location);
if ($result_location->num_rows > 0) {
    $row_location = $result_location->fetch_assoc();
    $location_name = $row_location['location_name'];
}
        $last_donation_date = $_POST['last_donation_date'];
        $availability = $_POST['availability'];

        $sql_update_profile = "UPDATE donor_profiles 
                              SET location = '$location_name', 
                                  last_donation_date = '$last_donation_date', 
                                  availability = '$availability' 
                              WHERE user_ID = '$user_ID'";

        if ($conn->query($sql_update_profile) === TRUE) {
            echo "<script>alert('Donor profile updated successfully');</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    // Donor profile does not exist, insert a new profile
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $location_id = $_POST['location']; // Assuming you're storing location ID in the users table

// Fetch location name based on location ID
$sql_location = "SELECT location_name FROM locations WHERE location_id = '$location_id'";
$result_location = $conn->query($sql_location);
if ($result_location->num_rows > 0) {
    $row_location = $result_location->fetch_assoc();
    $location_name = $row_location['location_name'];
}
        $last_donation_date = $_POST['last_donation_date'];
        $availability = $_POST['availability'];

        $sql_insert_profile = "INSERT INTO donor_profiles (donor_ID, user_ID, location, last_donation_date, availability) 
                               VALUES ('$user_ID', '$user_ID', '$location_name', '$last_donation_date', '$availability')";

        if ($conn->query($sql_insert_profile) === TRUE) {
            echo "<script>alert('Donor profile created successfully');</script>";
        } else {
            echo "Error: " . $sql_insert_profile . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
