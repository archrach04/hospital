<?php
$dbhost = "localhost";
$port = "5432";
$dbname = "hospital";
$dbuser = "postgres";
$dbpass = "dam999";

// Connect to PostgreSQL
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");

// Check connection
if ($conn) {
    session_start();

    $del_query = "DELETE FROM Appointment WHERE id = " . $_POST['app'];
    $result = pg_query($conn, $del_query);

    echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
          <meta charset='UTF-8'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Cancel Appointment</title>
          <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap'>
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
              margin-bottom: 20px;
              font-size: 30px;
              color: #002147;
              text-align: center;
            }

            p {
              font-size: 18px;
              color: #002147;
            }
          </style>
        </head>
        <body>
          <h1>Appointment Canceled</h1>
          <p>Have a nice day!</p>
        </body>
        </html>";
} else {
    die("Connection failed: " . pg_last_error());
}

// Close the connection
pg_close($conn);
?>

