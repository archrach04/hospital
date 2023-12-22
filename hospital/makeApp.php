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

    // Check connection
    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    } else {
        session_start();

        $make_query = "INSERT INTO Appointment (doctor_id, patient_id, hour, date) VALUES ('" . $_POST['Doctor'] . "', '" . $_SESSION['id'] . "', '" . $_POST['Hour'] . "' , '" . $_POST['Date'] . "')";
        $result = pg_query($conn, $make_query);

        if ($result) {
            // Move the header() function to the top
            header("Location: http://localhost/hospital/homepage_user.php");
            exit();
        } else {
            echo "Error: " . $make_query . "<br>" . pg_last_error($conn);
        }
    }

    // Close the PostgreSQL connection
    pg_close($conn);
?>
</body>
</html>