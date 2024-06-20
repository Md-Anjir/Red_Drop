<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 2px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ff8f8f;
        }
        h3{
            color: blue;
        }
    </style>
</head>
<body>
    <div style = "display: flex; justify-content: space-around; align-items: center; background-color: #d4f67e">
        <h1 style="color: red">Blood Donation Report</h1>
    </div>

    <?php
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

    // Query to get total number of blood requests
    $sql_total_requests = "SELECT COUNT(*) AS total_requests FROM blood_requests";
    $result_total_requests = $conn->query($sql_total_requests);
    $row_total_requests = $result_total_requests->fetch_assoc();
    $total_requests = $row_total_requests['total_requests'];

    // Query to get total amounr of blood requests
    $sql_total_amount_blood = "SELECT SUM(amount) AS total_amount_blood FROM blood_requests";
    $result_total_amount_blood = $conn->query($sql_total_amount_blood);
    $row_total_amount_blood = $result_total_amount_blood->fetch_assoc();
    $total_amount_blood = $row_total_amount_blood['total_amount_blood'];

    // Query to get number of successful requests
    $sql_successful_requests = "SELECT COUNT(*) AS success_count FROM blood_requests WHERE success = 'yes'";
    $result_successful_requests = $conn->query($sql_successful_requests);
    $row_successful_requests = $result_successful_requests->fetch_assoc();
    $successful_requests = $row_successful_requests['success_count'];



    echo "<h2>Total Blood Requests: $total_requests</h2>";
    echo "<h2>Total Amount of Blood bag: $total_amount_blood</h2>";
    echo "<h2>Total Successful Requests: $successful_requests</h2>";
    // echo "<p><br></p>";

    // Query to get details for each blood group
    $sql_blood_groups = "SELECT bloodGroup,COUNT(*) AS requests_count, SUM(amount) AS total_amount, 
                        SUM(CASE WHEN success = 'yes' THEN 1 ELSE 0 END) AS success_count,
                        COUNT(*) AS total_count
                        FROM blood_requests 
                        GROUP BY bloodGroup";
    $result_blood_groups = $conn->query($sql_blood_groups);

    if ($result_blood_groups->num_rows > 0) {
        echo "<h3>Blood Group Details:</h3>";
        echo "<table>";
        echo "<tr><th>Blood Group</th><th>Total Request</th><th>Total Amount (bag)</th><th>Success Rate</th></tr>";
        while($row_blood_groups = $result_blood_groups->fetch_assoc()) {
            $blood_group = $row_blood_groups['bloodGroup'];
            $requests_count = $row_blood_groups['requests_count'];
            $total_amount = $row_blood_groups['total_amount'];
            $success_count = $row_blood_groups['success_count'];
            $total_count = $row_blood_groups['total_count'];
            $success_rate = $total_count > 0 ? round(($success_count / $total_count) * 100, 2) : 0;
            echo "<tr><td>$blood_group</td><td>$requests_count</td><td>$total_amount</td><td>$success_rate%</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available for blood groups.";
    }

    // Query to get details for each location
    $sql_locations = "SELECT location, SUM(amount) AS total_amount, 
                      SUM(CASE WHEN success = 'yes' THEN 1 ELSE 0 END) AS success_count,
                      COUNT(*) AS total_count
                      FROM blood_requests 
                      GROUP BY location";
    $result_locations = $conn->query($sql_locations);

    if ($result_locations->num_rows > 0) {
        echo "<h3>Location Details:</h3>";
        echo "<table>";
        echo "<tr><th>Location</th><th>Total Request</th><th>Total Amount (Bag)</th><th>Success Rate</th></tr>";
        while($row_locations = $result_locations->fetch_assoc()) {
            $location = $row_locations['location'];
            $total_amount = $row_locations['total_amount'];
            $success_count = $row_locations['success_count'];
            $total_count = $row_locations['total_count'];
            $success_rate = $total_count > 0 ? round(($success_count / $total_count) * 100, 2) : 0;
            echo "<tr><td>$location</td><td>$total_count</td><td>$total_amount</td><td>$success_rate%</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available for locations.";
    }

    echo '<div style="text-align: center; margin-top: 20px;">';
    echo '<form action="admin.php" method="post">';
    echo '<button type="submit" style="color: white; font-size: large; background-color: red; padding: 8px 16px; cursor: pointer; border: none; border-radius: 5px;">Home Page</button>';
    echo '</form>';
    echo '</div>';

    // Close connection
    $conn->close();
    ?>
</body>
</html>
