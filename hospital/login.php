<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create a Doctor</title>
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
      overflow: hidden;
    }

    h1 {
      margin-bottom: 20px;
      font-size: 100px;
      color: #002147;
      text-align: center;
    }
</style>
</head>
<body>
    <form action="your_login_script.php" method="post">
    </form>
</body>
</html>

<?php
$dbhost = "localhost";
$port = "5432";
$dbname = "hospital";
$dbuser = "postgres";
$dbpass = "dam999";

// Connect to PostgreSQL
$conn = pg_connect("host=$dbhost port=$port dbname=$dbname user=$dbuser password=$dbpass");

// Check connection
if (!$conn) {
    die("Failed to connect to PostgreSQL.");
} else {
    $id = isset($_POST["username"]) ? pg_escape_string($_POST["username"]) : '';
    $pass = isset($_POST["pass"]) ? pg_escape_string($_POST["pass"]) : '';

    if (empty($id) || empty($pass)) {
        die("Username or password is empty");
    }

    $sql_patient = "SELECT username, id FROM patient WHERE username = '$id' AND password = '$pass'";
    $result_patient = pg_query($conn, $sql_patient);

    if ($result_patient === false) {
        die("Query failed: " . pg_last_error($conn));
    }

    $sql_admin = "SELECT username, id FROM admins WHERE username = '$id' AND password = '$pass'";
    $result_admin = pg_query($conn, $sql_admin);

    if ($result_admin === false) {
        die("Query failed: " . pg_last_error($conn));
    }

    if (pg_num_rows($result_patient) > 0) {
        session_start();
        $_SESSION['username'] = $id;
        $_SESSION['id'] = pg_fetch_assoc($result_patient)['id'];
        header("Location: http://localhost/hospital/homepage_user.php");
        die();
    } elseif (pg_num_rows($result_admin) > 0) {
        session_start();
        $_SESSION['username'] = $id;
        header("Location: http://localhost/hospital/admin.php");
        die();
    } else {
        pg_close($conn);
        die("Wrong username or password");
    }
}
?>
