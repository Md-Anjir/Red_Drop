<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if request ID and donor feedback are received
    if (isset($_POST['requestId']) && isset($_POST['donor_Feedback'])) {
        // Process the form data
        $requestId = $_POST['requestId'];
        $donorFeedback = $_POST['donor_Feedback'];

        // Database connection parameters
        $servername = "localhost";
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password
        $dbname = "practice"; // Replace with your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to update donor feedback in donor_acceptance table
        $sql = "UPDATE donor_acceptance SET donor_Feedback='$donorFeedback' WHERE requestId='$requestId'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Feedback submitted successfully.');</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        // Close connection
        $conn->close();
    } else {
        echo "Invalid data received.";
    }
} else {
    echo "Invalid request.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Responses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        .response {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .no-response {
            text-align: center;
            font-style: italic;
            color: #888;
        }
        .feedback-form {
            margin-top: 20px;
            text-align: center;
        }
        .feedback-form textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
            padding: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .feedback-form input[type="submit"] {
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
        }
        .feedback-form input[type="submit"]:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Previous Responses</h1>
    <?php
    // Start session
    session_start();

    // Check if user is logged in
    if(!isset($_SESSION['phone'])) {
        header("Location: login_form.html");
        exit;
    }
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
    // SQL query to select previous responses for the logged-in user
    $sql = "SELECT donor_acceptance.*, blood_requests.* FROM donor_acceptance JOIN blood_requests ON donor_acceptance.requestId = blood_requests.requestId WHERE donor_acceptance.donor_ID = '$user_ID'";
    $result = $conn->query($sql);

    // Check if there are any responses
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<div class='response'>";
            echo "<p><strong>Request ID:</strong> " . $row["requestId"]. "</p>";
            // Output other blood request information as desired
            echo "<p><strong>Blood Group:</strong> " . $row["bloodGroup"]. "</p>";
            echo "<p><strong>Amount:</strong> " . $row["amount"]. " units</p>";
            echo "<p><strong>Location:</strong> " . $row["location"]. "</p>";
            echo "<p><strong>Hospital:</strong> " . $row["hospital"]. "</p>";
            // Add more blood request information here if needed
            echo "<p><strong>Is selected?</strong> " . $row["is_selected"]. "</p>";
            // If response is selected, show feedback form
            if ($row["is_selected"] === "yes") {
                echo "<form class='feedback-form'  method='post'>";
                echo "<input type='hidden' name='requestId' value='" . $row["requestId"] . "'>";
                echo "<textarea name='donor_Feedback' placeholder='Enter your feedback'></textarea><br>";
                echo "<input type='submit' value='Submit Feedback'>";
                echo "</form>";
            }
            echo "</div>";
        }
    } else {
        echo "<div class='no-response'>No previous responses found.</div>";
    }
    echo '<div style="text-align: center; margin-top: 20px;">';
    echo '<form action="home.php" method="post">';
    echo '<button type="submit" style="color: white; font-size: large; background-color: red; padding: 8px 16px; cursor: pointer; border: none; border-radius: 5px;">Home Page</button>';
    echo '</form>';
    echo '</div>';    
    $conn->close();
    ?>
</div>
</body>
</html>
