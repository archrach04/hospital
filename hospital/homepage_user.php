<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Home Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap">
  <style>
    body {
      background-image: url('https://wallpapers.com/images/hd/medical-background-cjge7e89adg6ub8x.jpg'); /* Replace with your background image URL */
      background-size: cover;
      font-family: 'Abril Fatface', cursive; /* Use Abril Fatface font */
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      color: #002140; /* Text color */
      flex-direction: column;
      overflow: hidden; /* Make the page not scrollable */
    }

    h1 {
      order: -1; /* Move h1 (Health Connect) to the top */
      margin-bottom: 20px;
      font-size: 100px;
      color: #002147; /* Health Connect color */
      text-align: center;
    }

    .welcome-text {
      font-size: 30px; /* Increase welcome text size */
      text-align: center;
    }

    .action-buttons {
      display: flex;
      flex-wrap: wrap; /* Allow buttons to wrap to the next line */
      justify-content: center;
      align-items: center;
      margin-top: 50px;
    }

    .action-buttons a {
      margin: 10px;
      padding: 20px; /* Increase button size */
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 20px;
    }
  </style>
</head>
<body>

<?php
  session_start();

  $dbhost = "localhost";
  $port = "5432";
  $dbname = "hospital";
  $dbuser = "postgres";
  $dbpass = "dam999";

  // Connect to PostgreSQL
  $conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");

  if (!$conn) {
    echo "Failed to connect to PostgreSQL.";
    exit;
  }

  if (!isset($_SESSION['username'])) {
    $msg = "Please <a href='http://localhost/hospital/index.php'>register</a> to view this page";
    echo $msg;
  } else {
    $username = $_SESSION['username'];
    // Customize the SQL query based on your actual user table
    $result = pg_query($conn, "SELECT * FROM patient WHERE username = '$username'");
    
    if ($row = pg_fetch_assoc($result)) {
      echo "<h1>Health Connect</h1>";
      echo "<div class='welcome-text'>";
      echo "Welcome, " . $row['username'] . ".";
      echo "</div>";
      echo "<div class='action-buttons'>";
      echo "<a href='http://localhost/hospital/logout.php'>Click here to logout</a>";
      echo "<a href='http://localhost/hospital/makeAppointment.php'>Make an appointment</a>";
      echo "<a href='http://localhost/hospital/cancelAppointment.php'>Cancel an appointment</a>";
      echo "<a href='http://localhost/hospital/editAppointment.php'>Edit an appointment</a>";
      echo "</div>";
    }
  }

  pg_close($conn);
?>
</body>
</html>
