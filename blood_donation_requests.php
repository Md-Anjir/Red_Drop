<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Requests</title>
    <style>
        .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.card {
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.card h3 {
    color: #e74c3c;
}

.card p {
    margin-bottom: 10px;
}

button {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #2980b9;
}

    </style>
</head>
<body>
    <div class="container">
        <h1 style="color:blue">Blood Donation Requests</h1>

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


        // Retrieve user's blood group from donor_profiles table
        $phone = $_SESSION['phone'];
        $sql_get_blood_group = "SELECT * FROM users WHERE phone = '$phone'";
        $result_get_blood_group = $conn->query($sql_get_blood_group);

        if ($result_get_blood_group->num_rows == 1) {
            $row = $result_get_blood_group->fetch_assoc();
            $blood_group = $row['blood_group'];
            $user_ID = $row['user_ID'];

            // Retrieve udonor information
            $sql = "SELECT * FROM donor_profiles WHERE user_ID='$user_ID'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                // User found, display user information
                $row = $result->fetch_assoc();
                $location = $row['location'];
                $donor_ID = $row['donor_ID'];
                // $blood_group = $row['blood_group'];
                // You can retrieve other user information here
                
            // Retrieve blood donation requests with matching blood group
            // $sql_get_requests = "SELECT * FROM blood_requests WHERE bloodGroup = '$blood_group' AND success = 'no' AND location ='$location' ";

            $sql_get_requests = "SELECT * FROM blood_requests 
                     WHERE bloodGroup = '$blood_group' 
                     AND success = 'no' 
                     AND location = '$location'
                     AND NOT EXISTS (
                         SELECT * FROM donor_acceptance 
                         WHERE donor_acceptance.requestId = blood_requests.requestId 
                         AND donor_acceptance.donor_ID = '$donor_ID'
                     )";
            $result_get_requests = $conn->query($sql_get_requests);

            if ($result_get_requests->num_rows > 0) {
                // Display blood donation requests as cards
                while ($row = $result_get_requests->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<h3>Blood Group: ' . $row['bloodGroup'] . '</h3>';
                    echo '<p>Amount Needed: ' . $row['amount'] . ' units</p>';
                    echo '<p>Location: ' . $row['location'] . '</p>';
                    echo '<p>Hospital: ' . $row['hospital'] . '</p>';
                    // echo '<p>Phone No.: ' . $row['p_phone'] . '</p>';
                    echo '<p>Date: ' . $row['date'] . '</p>';
                    echo '<p>Time: ' . $row['time'] . '</p>';
                    echo '<p>Request_ID: ' . $row['requestId'] . '</p>';
                    // Button to respond to the request
                    echo '<form action="respond_to_request.php" method="post">';
                    echo '<input type="hidden" name="requestId" value="' . $row['requestId'] . '">';
                    echo '<button type="submit">Respond</button>';
                    echo '</form>';
                    echo '</div>';
                }
                } else {
                    echo '<div style="text-align: center; margin-top: 50px;">';
                    echo '<h2 style = "color:red">No blood donation requests found matching your blood group and location.</h2>';
                    echo '</div>';
                    echo '<br>';
                }
            } else {
                // User not found
                echo '<div style="text-align: center; margin-top: 50px;">';
                echo '<h2 style = "color:red">User not found in Donor list.</h2>';
                echo '</div>';
                echo '<br>';
            }


            } else {
                echo '<p>Error retrieving blood group.</p>';
            }
            echo '<div style="text-align: center; margin-top: 20px;">';
            echo '<form action="home.php" method="post">';
            echo '<button type="submit" style="color: white; font-size: large; background-color: red; padding: 8px 16px; cursor: pointer; border: none; border-radius: 5px;">Home Page</button>';
            echo '</form>';
            echo '</div>';
        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
