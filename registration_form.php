<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration Form</title>
  <link rel="stylesheet" href="styles.css">
  <script>
    function validateForm() {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("confirm_password").value;

      if (password != confirmPassword) {
        alert("Passwords do not match");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>New User Registration Form</h2>
    <form action="register.php" method="post" onsubmit="return validateForm()">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      
      <label for="phone">Phone Number:</label>
      <input type="text" id="phone" name="phone" required>
      
      <label for="blood_group">Blood Group:</label>
      <select id="blood_group" name="blood_group" required>
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
      
      <label for="gender">Gender:</label>
      <select id="gender" name="gender" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>
      
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" required>
      
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

      <label for="act_like">Singup as:</label>
      <select id="act_like" name="act_like" required>
        <option value="donor">Donor</option>
        <option value="receiver">Receiver</option>
      </select>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required>

      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login_form.html">Login here</a></p>
  </div>
</body>
</html>
