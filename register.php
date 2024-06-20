<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practice";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$blood_group = $_POST['blood_group'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
// $location = $_POST['location'];
$act_like = $_POST['act_like'];
$password = $_POST['password'];

// Default role value
$role = "user";

$location_id = $_POST['location']; // Assuming you're storing location ID in the users table

// Fetch location name based on location ID
$sql_location = "SELECT location_name FROM locations WHERE location_id = '$location_id'";
$result_location = $conn->query($sql_location);
if ($result_location->num_rows > 0) {
    $row_location = $result_location->fetch_assoc();
    $location_name = $row_location['location_name'];
}

// Check if user already exists
$sql = "SELECT * FROM users WHERE phone='$phone'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "User with this phone number already exists.";
} else {
    // Insert new user
    $sql = "INSERT INTO users (user_ID, name, phone, blood_group, gender, dob, location, act_like, role, password)
    VALUES ('$phone','$name', '$phone', '$blood_group', '$gender', '$dob', '$location_name', '$act_like', '$role', '$password')";


    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
