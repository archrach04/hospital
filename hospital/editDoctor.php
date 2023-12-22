<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit a Doctor</title>
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

    select, input[type="submit"], input[type="text"] {
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
  ?>
  <form action="modifyDoctor.php" method="post" class="form-box">
  <h2> Edit Doctor </h2>
    <select name="Old_Doctor">
      <?php
      $id_doctor_query = "SELECT id, fname, lname FROM Doctor";
      $id_result = pg_query($conn, $id_doctor_query);

      while ($row2 = pg_fetch_assoc($id_result)) {
        echo "<option value='".$row2['id']."'>" . $row2['fname'] . " " . $row2['lname'] . "</option>";
      }
      ?>
    </select>
    <h1> Health Connect</h1>
    
    <p>fname: <input type="text" name="fname" /></p>
    <p>lname: <input type="text" name="lname" /></p>
    <select name="Branch">
      <?php
      $branch_query = "SELECT name FROM Branches";
      $branch_result = pg_query($conn, $branch_query);

      while ($row2 = pg_fetch_assoc($branch_result)) {
        echo "<option value='".$row2['name']."'>" . $row2['name'] . "</option>";
      }
      ?>
    </select>
    <p><input type="submit" value="Submit" /></p>
  </form>  
  <br />
</body>
</html>
