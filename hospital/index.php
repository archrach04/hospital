<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            color:#002147;
            text-align: center;
            margin-bottom: 50px;
            margin-left: 450px;
        }

        form {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 50px;
            border-radius: 10px;
            text-align: center;
            width: 300px; /* Set the width as needed */
            margin-bottom: -10px; /* Adjust margin */
            margin-left: 600px;
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
            margin-left: 600px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = isset($_POST["username"]) ? pg_escape_string($_POST["username"]) : '';
        $pass = isset($_POST["pass"]) ? pg_escape_string($_POST["pass"]) : '';

        if (empty($id) || empty($pass)) {
            echo "<div class='container'>";
            echo "<h1>Health Connect</h1>";
            echo "<div class='error-message'>Username or password is empty</div>";
            echo "<form action='login.php' method='post'>";
            echo "<p>Username: <input type='text' name='username' /></p>";
            echo "<p>Password: <input type='password' name='pass' /></p>";
            echo "<p><input type='submit' /></p>";
            echo "</form>";
            echo "<div class='register-link'>";
            echo "<p>Click <a href='http://localhost/hospital/registration.php'>here</a> to register.</p>";
            echo "</div>";
            echo "</div>";
            exit;
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
            $_SESSION['username'] = $id;
            $_SESSION['id'] = pg_fetch_assoc($result_patient)['id'];
            header("Location: http://localhost/hospital/homepage_user.php");
            die();
        } elseif (pg_num_rows($result_admin) > 0) {
            $_SESSION['username'] = $id;
            header("Location: http://localhost/hospital/admin.php");
            die();
        } else {
            // Display wrong username or password with CSS style
            echo "<div class='container'>";
            echo "<h1>Health Connect</h1>";
            echo "<div class='error-message'>Wrong username or password</div>";
            echo "<form action='login.php' method='post'>";
            echo "<p>Username: <input type='text' name='username' /></p>";
            echo "<p>Password: <input type='password' name='pass' /></p>";
            echo "<p><input type='submit' /></p>";
            echo "</form>";
            echo "<div class='register-link'>";
            echo "<p>Click <a href='http://localhost/hospital/registration.php'>here</a> to register.</p>";
            echo "</div>";
            echo "</div>";
            exit;
        }
    } else {
        if (!isset($_SESSION['username'])) {
            ?>
            <div class="container">
                <h1>Health Connect</h1>
                <form action="login.php" method="post">
                    <p>Username: <input type="text" name="username" /></p>
                    <p>Password: <input type="password" name="pass" /></p>
                    <p><input type="submit" /></p>
                </form>
                <div class="register-link">
                    <p>Click <a href="http://localhost/hospital/registration.php">here</a> to register.</p>
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
    }

    pg_close($conn);
    ?>
</body>
</html>