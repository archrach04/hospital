<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Roboto:wght@700&display=swap">
    <style>
        body {
            background-image: url('https://static.vecteezy.com/system/resources/previews/002/509/850/non_2x/doctor-using-a-digital-tablet-working-on-hospital-free-photo.jpg');
            background-size: cover;
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden; /* Disable scrolling */
            color: #fff;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center the items horizontally */
        }

        h1 {
            font-family: 'Abril Fatface', cursive;
            font-size: 100px;
            font-weight: normal;
            color: #002147;
            text-align: center;
            margin-bottom: 40px;
            margin-left: 450px;
        }

        form {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 50px;
            border-radius: 10px;
            text-align: center;
            width: 300px; /* Set the width as needed */
            margin-bottom: -30px; /* Adjust margin */
            margin-left:600px;
        }

        input {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }

        .register-link {
            text-align: center;
            margin-top: -39px; /* Adjust margin */
            margin-left:600px;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    $dbhost = "localhost";
    $port = "5432";
    $dbname = "hospital";
    $dbuser = "postgres";
    $dbpass = "dam999";

    $conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");

    if (!$conn) {
        echo "Failed to connect to PostgreSQL.";
        exit;
    }

    if (!isset($_SESSION['username'])) {
        ?>
        <div class="container">
            <h1>Health Connect</h1>
            <form action="create_user.php" method="post">
                <p>Username: <input type="text" name="id" /></p>
                <p>Password: <input type="password" name="pass" /></p>
                <p>First Name: <input type="text" name="fname" /></p>
                <p>Last Name: <input type="text" name="lname" /></p>
                <p><input type="submit" /></p>
            </form>
            <div class="register-link">
                <p>Click <a href="http://localhost/hospital/logout.php">here</a> to log out.</p>
            </div>
        </div>
        <?php
    } else {
        echo "Welcome, " . $_SESSION['username'] . ".";
        ?>
        <br />
        Click <a href="http://localhost/hospital/logout.php">here</a> to log out.
        <?php
    }

    pg_close($conn);
    ?>
</body>
</html>
