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
    $name = $row['name'];
    $user_ID = $row['user_ID'];
    $blood_group = $row['blood_group'];
    // You can retrieve other user information here
} else {
    // User not found
    echo "User not found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Red Drop - account</title>
    <style>
      * {
        box-sizing: border-box;
        list-style-type: none;
        margin: 0;
        padding: 0;
        outline: none;
        text-decoration: none;
      }
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f7f7f7;
      }
      .header {
        background-color:rgb(252, 77, 77);;
        color: white;
        text-align: center;
        align-items: center;
        font-size: small;
      }
      .flex-space-around {
        display: flex;
        justify-content: space-around;
        align-items: center;
      }

      nav {
        font-size: 1.2rem;
        position: sticky;
        top: 0;
        left: 0;
      }

      .nav-upper {
        min-height: 10vh;
        background-color: rgb(254, 57, 57);
        padding: 1rem 0;
      }
      .nav_list {
        transition: var(--transition);
      }
      .nav_list:hover {
        color: black;
      }
      .nav_link {
        color: white;
        transition: var(--transition);
      }
      .nav_link:hover {
        color: black;
        font-size: 24px;
      }
      .footer {
        background-color: black;
        color: white;
        text-align: center;
        padding: 20px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
      }
      .content {
        padding: 20px;
        text-align: center;
      }
      a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
        font-size: large;
      }
      .logo-icon {
        width: 4rem;
        height: 4rem;
        transition: var(--transition);
      }
      .logo-icon:hover {
        transition: var(--transition);
      }
      @media (max-width: 990px){
    .flex-space-around{
        flex-direction: column;
        gap: 1rem;
        padding: 1rem 0;
    }
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1;
}

.nav_list:hover .dropdown-menu {
    display: block;
}

.dropdown-menu li {
    padding: 10px;
}

.dropdown-menu li:hover {
    background-color: #f2f2f2;
}

.dropdown-menu li a {
  font-size: large;
    color: black;
    text-decoration: none;
}


    </style>
  </head>
  <body>
    <div class="header">
      <nav>
        <ul class="nav-upper flex-space-around">
          <li class="nav_list">
            <a href="index.html" class="nav_link"
              ><img class="logo-icon" src="./image/logo.png" alt=""
            /></a>
          </li>
          <li class="nav_list">
    <a href="#" class="nav_link">Blood Request</a>
    <ul class="dropdown-menu">
        <li><a href="blood_request_form.php">New Request</a></li>
        <li><a href="previous_request.php">Previous Request</a></li>
    </ul>
</li>
<li class="nav_list">
    <a href="#" class="nav_link">See Requests</a>
    <ul class="dropdown-menu">
        <li><a href="blood_donation_requests.php">New Requests</a></li>
        <li><a href="response_requests.php">My Response</a></li>
    </ul>
</li>
          <li class="nav_list">
            <a href="contact.html" class="nav_link">Contact</a>
          </li>
          <li class="nav_list">
            <a href="donor_profile_form.php" class="nav_link">Update Profile</a>
          </li>
          <li class="nav_list">
            <a href="logout.php" class="nav_link">Logout</a>
          </li>
        </ul>
      </nav>
    </div>

    <div class="content">
      <h1>Welcome to Red Drop Account, <?php echo $name; ?></h1>
      <h3>Your User ID: <?php echo $user_ID; ?> </h3>
      <p style="font-size: large;">
        Red Drop is a platform dedicated to facilitating blood donation and
        saving lives. Our mission is to connect blood donors with those in need.
      </p>
      <p>Your blood group: <?php echo $blood_group; ?></p>
      <!-- Display other user information here -->
    </div>

    <div class="footer">
        <div id="footer" class="flex-space-around">

            <div class="footer-section" style="margin-bottom: 20px;">
                <h2 style="margin-bottom: 10px;">Contact Us</h2>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 8px;">Email: <a href="mailto:mdanjir3734@gmail.com">mdanjir3734@gmail.com</a></li>
                    <li style="margin-bottom: 8px;">Phone: <a href="tel:+8801738851118">+8801738851118</a></li>
                </ul>
            </div>
        
            <div class="footer-section" style="margin-bottom: 20px;">
                <h2 style="margin-bottom: 10px;">Quick Links</h2>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 8px;"><a href="home.php">Home</a></li>
                    <li style="margin-bottom: 8px;"><a href="#">About Us</a></li>
                    <li style="margin-bottom: 8px;"><a href="#">Contact</a></li>
                </ul>
            </div>
        
            <div class="footer-section" style="margin-bottom: 20px;">
                <h2 style="margin-bottom: 10px;">Follow Us</h2>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 8px;"><a href="https://www.facebook.com/md.anjir.7">Facebook</a></li>
                    <li style="margin-bottom: 8px;"><a href="#">Twitter</a></li>
                    <li style="margin-bottom: 8px;"><a href="#">Instagram</a></li>
                </ul>
            </div>
        </div>
        <p style="text-align: center; ">Copyright &copy; Red Drop authority</p>
            
        </div>

    </div>
  </body>
</html>
