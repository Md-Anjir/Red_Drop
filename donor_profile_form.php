<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Donor Profile</title>
    <style>
      .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .form-group {
        margin-bottom: 20px;
      }

      label {
        display: block;
        font-weight: bold;
      }

      input[type="text"],
      input[type="date"],
      select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
      }

      button {
        background-color: #4caf50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
      }

      button:hover {
        background-color: #45a049;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Update Donor Profile</h2>
      <form action="update_donor_profile.php" method="post">
        <div class="form-group">
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
        </div>
        <div class="form-group">
          <label for="last_donation_date">Last Donation Date:</label>
          <input
            type="date"
            id="last_donation_date"
            name="last_donation_date"
            required
          />
        </div>
        <div class="form-group">
          <label for="availability">Availability:</label>
          <select id="availability" name="availability" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
          </select>
        </div>
        <button type="submit">Update Profile</button>
      </form>
    </div>
  </body>
</html>
