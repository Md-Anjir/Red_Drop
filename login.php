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
$phone = $_POST['phone'];
$password = $_POST['password'];
$role = $_POST['role'];

// Validate user credentials
$sql = "SELECT * FROM users WHERE phone='$phone' AND password='$password' AND role='$role'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Start session
    session_start();
    $_SESSION['phone'] = $phone;
    $_SESSION['role'] = $role;

    // Redirect based on role
    if ($role == 'user') {
        header("Location: home.php");
    } elseif ($role == 'admin') {
        header("Location: admin.php");
    }
    exit;
} else {
    echo "Login failed. Please check your credentials.";
}

$conn->close();
?>
