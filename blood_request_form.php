<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Request Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            /* min-height: 700px; */
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: large;
        }
        h2 {
            color: red;
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: large;
        }
        input[type="submit"] {
            width: 100%;
            background-color: blue;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Blood Request Form</h2>
        <form action="request_process_form.php" method="POST">
        <label for="p_name">Patient Name:</label>
      <input type="text" id="p_name" name="p_name" required>
      
      <label for="p_phone">Phone Number:</label>
      <input type="text" id="p_phone" name="p_phone" required>

      <label for="disease">Disease:</label>
      <input type="text" id="disease" name="disease" required>
      
            <label for="bloodGroup">Blood Group:</label>
            <select id="bloodGroup" name="bloodGroup" required>
                <option value="">Select</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="amount">Amount of Blood Needed (in units):</label>
            <input type="number" id="amount" name="amount" min="1" required>
            <p></p>
            <label for="location">Location:</label>
      <select id="location" name="location" required>
        <option value="">Select Location</option>
        <?php
          // Connect to the MySQL database
          $conn = new mysqli('localhost', 'root', '', 'practice');

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Fetch locations from the database
          $sql = "SELECT location_id, location_name FROM locations";
          $result = $conn->query($sql);

          // Populate dropdown options
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['location_id'] . "'>" . $row['location_name'] . "</option>";
              }
          }

          // Close database connection
          $conn->close();
        ?>
      </select>
            <p></p>
            <label for="hospital">Hospital:</label>
            <select id="hospital" name="hospital" required>
        <option value="">Select hospital</option>
        <?php
          // C<?phponnect to the MySQL database
          $conn = new mysqli('localhost', 'root', '', 'practice');

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Fetch hospitals from the database
          $sql = "SELECT hospital_id, hospital_name FROM hospitals";
          $result = $conn->query($sql);

          // Populate dropdown options
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['hospital_id'] . "'>" . $row['hospital_name'] . "</option>";
              }
          }

          // Close database connection
          $conn->close();
        ?>
            <p></p>
            <!-- <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>
            <p></p> -->
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            <p></p>
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
            <br>
            <p></p>
            <input type="submit" value="Submit Request">
        </form>
    </div>
    <?php
        echo '<div style="text-align: center; margin-top: 20px;">';
        echo '<form action="home.php" method="post">';
        echo '<button type="submit" style="color: white; font-size: large; background-color: red; padding: 8px 16px; cursor: pointer; border: none; border-radius: 5px;">Home Page</button>';
        echo '</form>';
        echo '</div>';
    ?>
</body>
</html>
