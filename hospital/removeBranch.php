<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
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

    form {
      background-color: rgba(255, 255, 255, 0.7);
      border-radius: 10px;
      padding: 20px;
      margin: 20px;
      display: flex;
      align-items: center;
      flex-direction: column;
    }

    select, input[type="submit"] {
      margin: 10px;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
    }

    a {
      color: #4CAF50;
      text-decoration: none;
      font-size: 16px;
      margin-top: 10px;
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
      echo "Failed to connect to PostgreSQL.";
      exit;
    }
  ?>

  <h1>Health Connect</h1>
  

  <form action="deleteBranch.php" method="post">
  <h2>Remove a Branch</h2>
   <select name="Old_Branch">
    <?php
    $id_branch_query = "SELECT name, id FROM Branches";
    $id_result = pg_query($conn, $id_branch_query);
    while ($row2 = pg_fetch_assoc($id_result)) {
      echo "<option value='".$row2['id']."'>" . $row2['name'] . "</option>";
    }
    ?>
    
  </select>

  <p><input type="submit" /></p>
</form>

<br />


<?php
  pg_close($conn);
?>
</body>
</html>
