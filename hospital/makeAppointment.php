<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Make an Appointment Page</title>
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
      margin-bottom: 20px;
      font-size: 100px;
      color: #002147;
      text-align: center;
    }

    .form-box {
      background-color: rgba(255, 255, 255, 0.7);
      border-radius: 10px;
      padding: 20px;
      margin: 20px;
      display: flex;
      align-items: center;
      flex-direction: column;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    select, input[type="submit"] {
      margin: 10px;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
    }

    table {
      border-collapse: collapse;
      margin-top: 20px;
    }

    th {
      border: 1px solid #ddd;
      padding: 15px;
      text-align: center;
    }

    .busy {
      background-color: #FF0000;
      color: #FFFFFF;
      padding: 10px;
      border-radius: 5px;
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

    if (!$conn) {
      die("Failed to connect to PostgreSQL.");
    } else {
      echo "<h1>Health Connect</h1>";
      echo "<h2>Make an Appointment</h2>";
      echo "<div class='form-box'>";
      echo "<form action='makeAppointment.php' method='post'>";

      // Fetch branches from the database
      $branchQuery = "SELECT DISTINCT branch FROM Doctor";
      $branchResult = pg_query($conn, $branchQuery);

      echo "<p>Branch: <select name='Branch' onchange='this.form.submit()'>";
      echo "<option disabled selected>Select a branch</option>";

      while ($branchRow = pg_fetch_assoc($branchResult)) {
        $selected = ($_POST['Branch'] == $branchRow['branch']) ? 'selected' : '';
        echo "<option value='" . $branchRow['branch'] . "' $selected>" . $branchRow['branch'] . "</option>";
      }

      echo "</select></p>";

      if (isset($_POST['Branch'])) {
        $selectedBranch = $_POST['Branch'];

        // Fetch doctors based on the selected branch
        $doctorQuery = "SELECT id, fname FROM Doctor WHERE branch='$selectedBranch'";
        $doctorResult = pg_query($conn, $doctorQuery);

        echo "<p>Doctor: <select name='Doctor'>";

        if ($doctorResult) {
          while ($doctorRow = pg_fetch_assoc($doctorResult)) {
            $selectedDoctor = ($_POST['Doctor'] == $doctorRow['id']) ? 'selected' : '';
            echo "<option value='" . $doctorRow['id'] . "' $selectedDoctor>" . $doctorRow['fname'] . "</option>";
          }
        }

        echo "</select></p>";
      }

      echo "<p>Date: <select name='Date'>";
      $day_counts = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
      for ($i = 0; $i < 12; $i++) {
        for ($j = 1; $j <= $day_counts[$i]; $j++) {
          $date_value = "2023-" . ($i+1) . "-" . $j;
          echo "<option value='" . $date_value . "'>" . ($i+1) . "/" . $j . "</option>";
        }
      }
      echo "</select></p>";

      echo "<p><input type='submit' /></p>";
      echo "</form>";
    

      if (isset($_POST['Branch']) && isset($_POST['Doctor'])) {
        $sql = "SELECT hour FROM Appointment WHERE doctor_id=" . $_POST['Doctor'] . " AND date='" . $_POST['Date'] . "'";

        $hour_arr = str_repeat('0', 24);

        $result = pg_query($conn, $sql);

        while ($row = pg_fetch_assoc($result)) {
          $hour_arr[intval($row['hour'])] = '1';
        }

        // Display available appointment slots in a 2x9 grid
        echo "<table>";
        echo "<tr>";
        for ($i = 0; $i < 24; $i++) {
          $hour = sprintf("%02d", $i);

          if ($hour_arr[$i] == '1') {
            echo "<th><span class='busy'>" . $hour . ":00</th>";
            continue;
          }
          ?>
          <th>
          
            <form action="makeApp.php" method="post">
              <input type="hidden" name="Hour" value="<?php echo $i; ?>">
              <input type="hidden" name="Date" value="<?php echo $_POST['Date']; ?>">
              <input type="hidden" name="Doctor" value="<?php echo $_POST['Doctor']; ?>">
              <input type="submit" value="<?php echo $hour . ":00"; ?>">
            </form>
          </th>
          <?php
        
          if (($i + 1) % 9 == 0) {
            echo "</tr><tr>";
          }
        }
        echo "</tr>";
        echo "</table>";
      }
      echo "</div>";
    }
  ?>

</body>
</html>