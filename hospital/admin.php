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
      order: -1;
      margin-bottom: 20px;
      font-size: 100px;
      color: #002147;
      text-align: center;
    }

    .welcome-text {
      font-size: 30px;
      text-align: center;
    }

    .action-buttons {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      margin-top: 50px;
    }

    .action-buttons a {
      margin: 10px;
      padding: 20px;
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
  ?>
  <h1>Health Connect</h1>
  <div class='welcome-text'>
    Click <a href="http://localhost/hospital/logout.php">here</a> to log out.
  </div>
  <br>
  <div class='action-buttons'>
    <a href='http://localhost/hospital/addDoctor.php'>Create a doctor</a>
    <a href='http://localhost/hospital/removeDoctor.php'>Remove a doctor</a>
    <a href='http://localhost/hospital/editDoctor.php'>Edit a doctor</a>
    <a href='http://localhost/hospital/addBranch.php'>Create a branch</a>
    <a href='http://localhost/hospital/removeBranch.php'>Remove a branch</a>
    <a href='http://localhost/hospital/editBranch.php'>Edit a branch</a>
  </div>
</body>
</html>
