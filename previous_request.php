<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Blood Requests</title>
    <style>
        table {
            font-size: large;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .donor-response {
            display: none;
        }
    </style>
    <script>
        function selectDonor(requestId, donorId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert("Donor selected successfully.");
                }
            };
            xhttp.open("GET", "select_donor.php?requestId=" + requestId + "&donorId=" + donorId, true);
            xhttp.send();
        }
        
        function updateSuccess(requestId, newValue) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert("Success status updated successfully.");
                }
            };
            xhttp.open("GET", "update_success.php?requestId=" + requestId + "&newValue=" + newValue, true);
            xhttp.send();
        }
        
        function showDonorResponsesDropdown(select) {
            var requestId = select.value;
            var selectedDiv = document.getElementById("donorResponse_" + requestId);
            var otherDivs = document.querySelectorAll(".donor-response");
            otherDivs.forEach(function(div) {
                if (div !== selectedDiv) {
                    div.style.display = "none";
                }
            });
            selectedDiv.style.display = "block";
        }
    </script>
</head>
<body>
    <h2>Previous Blood Requests</h2>
    <table>
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Blood Group</th>
                <th>Amount (units)</th>
                <th>Location</th>
                <th>Hospital</th>
                <th>Date</th>
                <th>Time</th>
                <th>Success</th>
                <th>Donor Responses</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Start session
            session_start();

            // Check if user is logged in
            if(!isset($_SESSION['phone'])) {
                header("Location: login_form.html");
                exit;
            }

            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'practice');

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

            // Fetch blood requests
            $sql = "SELECT * FROM blood_requests WHERE user_ID='$user_ID'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['requestId'] . "</td>";
                    echo "<td>" . $row['bloodGroup'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td>" . $row['hospital'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['time'] . "</td>";
                    echo "<td>";
                    echo "<select onchange='updateSuccess(" . $row['requestId'] . ", this.value)'>";
                    echo "<option value='yes'" . ($row['success'] == 'yes' ? ' selected' : '') . ">Yes</option>";
                    echo "<option value='no'" . ($row['success'] == 'no' ? ' selected' : '') . ">No</option>";
                    echo "</select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<select onchange='selectDonor(" . $row['requestId'] . ", this.value)'>";
                    echo "<option value=''>Select Donor</option>";

                    // Fetch donor responses for the current request
                    $requestId = $row['requestId'];
                    $sql2 = "SELECT * FROM donor_acceptance WHERE requestId = '$requestId'";
                    $result2 = $conn->query($sql2);

                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            echo "<option value='" . $row2['donor_ID'] . "'>Donor ID: " . $row2['donor_ID'] . ", Is Selected: " . $row2['is_selected'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No donor responses found</option>";
                    }

                    echo "</select>";
                    echo "<div class='donor-response' id='donorResponse_" . $requestId . "'></div>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No blood requests found</td></tr>";
            }

            // Close database connection
            $conn->close();
            ?>
        </tbody>
    </table>
    <?php
        echo '<div style="text-align: center; margin-top: 20px;">';
        echo '<form action="home.php" method="post">';
        echo '<button type="submit" style="color: white; font-size: large; background-color: red; padding: 8px 16px; cursor: pointer; border: none; border-radius: 5px;">Home Page</button>';
        echo '</form>';
        echo '</div>';
    ?>
</body>
</html>
