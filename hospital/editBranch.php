<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Branch Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Roboto:wght@700&display=swap">
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

    form {
      background-color: rgba(255, 255, 255, 0.7);
      border-radius: 10px;
      padding: 20px;
      margin: 20px;
      display: flex;
      align-items: center;
      flex-direction: column;
    }

    select, input[type="text"], input[type="submit"] {
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
        die("Failed to connect to PostgreSQL.");
    }

    // Fetch existing branches
    $id_branch_query = "SELECT id, name FROM Branches";
    $id_result = pg_query($conn, $id_branch_query);
  
  ?>
  <h1 style="font-size: 100px;">Health Connect</h1>

  <form action="modifyBranch.php" method="post">
  <h2> Edit branch name </h2>
    <select name="Old_Branch">
      <?php
        while ($row2 = pg_fetch_assoc($id_result)) {
            echo "<option value='".$row2['id']."'>" . $row2['name'] . "</option>";
        }
      ?>
    </select>
    <p>Branch Name: <input type="text" name="name" /></p>
    <p><input type="submit" /></p>
  </form>  
  <br />
  
</body>
</html>
