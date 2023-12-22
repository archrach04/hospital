<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cancel Appointment Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap">
  <style>
    body {
      background-image: url('https://wallpapers.com/images/hd/medical-background-cjge7e89adg6ub8x.jpg');
      background-size: cover;
      font-family: 'Abril Fatface', cursive;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      color: #002140;
      flex-direction: column;
    }

    h1 {
      order: -1;
      margin-bottom: 10px;
      font-size: 60px; /* Reduced font size */
      color: #002147;
      text-align: center;
    }

    table {
      border-collapse: collapse;
      margin-top: 10px; /* Reduced margin */
      background-color: #fff; /* Solid background color */
      width: 70%; /* Reduced table width */
    }

    th {
      border: 1px solid #ddd;
      padding: 10px; /* Reduced padding */
      text-align: center;
    }
  </style>
</head>
<body>
  <?php
    $dbhost = "localhost";
    $port = "5432";
    $dbname = "hospital";
    $dbuser = "postgres";
    $dbpass = "dam999";
  
    // Connect to PostgreSQL
    $conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");

    // Check connection
    if (!$conn) {
      die("Failed to connect to PostgreSQL.");
    } else {
      session_start();

      // Ensure $_SESSION['id'] is set before using it in the query
      if (!isset($_SESSION['id'])) {
        die("User ID not set in the session.");
      }

      $query = "SELECT * FROM Appointment WHERE patient_id = " . $_SESSION['id'];

      $result = pg_query($conn, $query);

      if ($result) {
        ?>
        <h1 style=font: size 100px;>Health Connect</h1>
        <h2>Cancel Appointment</h2>
        <table border="1">
          <tr>
            <th>Doctor</th>
            <th>Action</th>
          </tr>
          <?php
          while ($row2 = pg_fetch_assoc($result)) {
            $hour = sprintf("%02d", 8 + intval($row2['hour'] / 12));
            $min = sprintf("%02d", $row2['hour'] % 12 * 5);
            $sql = "SELECT fname, lname FROM Doctor WHERE id = '" . $row2['doctor_id'] . "'";
            
            // Check if the query was successful
            $resultDoctor = pg_query($conn, $sql);
            if ($resultDoctor) {
                // Check if there are rows to fetch
                $rowDoctor = pg_fetch_assoc($resultDoctor);
                if ($rowDoctor) {
                    echo "<tr><th>" . $rowDoctor['fname'] . " " . $rowDoctor['lname'] .  "," . $hour . ":" . $min . "</th>";
                    ?>
                    <th>
                        <form action="cancelApp.php" method="post">
                            <input type="hidden" name="app" value="<?php echo $row2['id'];?>">
                            <input type="submit" value="Cancel">
                        </form>
                    </th>
                    </tr>
                    <?php
                } else {
                    echo "No data found for Doctor with ID " . $row2['doctor_id'];
                }
            } else {
                echo "Query failed: " . pg_last_error($conn);
            }
        }
        ?>
      </table>  
      <?php
    } else {
      die("Query failed: " . pg_last_error($conn));
    }
  }
  ?>
</body>
</html>



