<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit an Appointment Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap">
  <style>
    body {
      background-image: url('https://wallpapers.com/images/hd/medical-background-cjge7e89adg6ub8x.jpg');
      background-size: cover;
      font-family: 'Abril Fatface', cursive;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      color: #002140;
    }

    h1 {
      margin-bottom: -30px;
      font-size: 100px;
      color: #002147;
      text-align: center;
    }

    table {
      border-collapse: collapse;
      margin-top: 20px;
      width: 80%;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 15px;
      text-align: center;
    }

    select, input[type="submit"] {
      margin: 10px;
      padding: 10px;
      font-size: 16px;
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
      die("Connection failed: " . pg_last_error());
    } else {
      session_start();

      $query = "SELECT * FROM Appointment WHERE patient_id = " .  $_SESSION['id'];

      $result = pg_query($conn, $query);
  ?>
  <h1>Health Connect</h1>
  <table border="1">
    <tr>
      <th>Doctor</th>
      <th>Edit Appointment</th>
    </tr>
    <?php
    while ($row2 = pg_fetch_assoc($result)) {
      if (is_array($row2) && count($row2) > 0) {
        $hour = sprintf("%02d", 8 + intval($row2['hour'] / 12));
        $min = sprintf("%02d", $row2['hour'] % 12 * 5);
        $sql = "SELECT fname, lname FROM Doctor WHERE id = '" .  $row2['doctor_id'] . "'";
        $resultDoctor = pg_query($conn, $sql);
        $rowDoctor = pg_fetch_assoc($resultDoctor);
        if ($hour >= 12) {
          $hour++;
        }
        echo "<tr><td>" . $rowDoctor['fname'] . " " . $rowDoctor['lname'] .  ", " . $hour . ":" . $min . "</td>";
        ?>
        <td>
          <form action="editApp.php" method="post">
            <input type="hidden" name="app" value="<?php echo $row2['id'];?>">
            <select name="new_doctor">
              <?php
              $id_doctor_query = "SELECT fname, lname, id FROM Doctor";
              $id_result = pg_query($conn, $id_doctor_query);
              while ($rowDoctor = pg_fetch_assoc($id_result)) {
                echo "<option value='".$rowDoctor['id']."'>" . $rowDoctor['fname'] . "</option>";
              }
              ?>
            </select>
            <p>Date: <select name='Date'>
              <?php
              $day_counts = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
              for ($i = 0; $i < 12; $i++) {
                for ($j = 1; $j <= $day_counts[$i]; $j++) {
                  $date_value = "2017-" . ($i+1)."-".$j;
                  echo "<option value='".$date_value."'>".($i+1)."/".$j."</option>";
                }
              }
              ?>
            </select></p>
            <select name="new_hour">
              <?php
              for ($j=0; $j < 96; $j++) {
                $hour = sprintf("%02d", 8 + intval($j / 12));
                $min = sprintf("%02d", $j % 12 * 5);
                if ($hour > 11) {
                  $hour++;
                }
                echo "<option value='". $j ."'>" . $hour . ":" . $min . "</option>";
              }
              ?>
            </select>
            <input type="submit" value="Edit">
          </form>
        </td>
        <?php
        echo "</tr>";
      }
    }
    ?>
  </table>  
  <?php
  }
  ?>
</body>
</html>
