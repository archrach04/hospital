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
    die("Connection failed: " . pg_last_error());
} else {
    session_start();

    // Sanitize input
    $date = pg_escape_string($_POST['Date']);
    $new_doctor = isset($_POST['new_doctor']) ? (int)$_POST['new_doctor'] : null;  // Assuming doctor_id is an integer
    $new_hour = isset($_POST['new_hour']) ? (int)$_POST['new_hour'] : null;
    $app_id = isset($_POST['app']) ? pg_escape_string($_POST['app']) : null;

    // Check for conflicts
    $check_query = "SELECT COUNT(*) AS conflict_count FROM Appointment WHERE date = '" . $date . "' AND doctor_id = " . $new_doctor . " AND hour = " . $new_hour;
    $conflict_result = pg_query($conn, $check_query);

    if ($conflict_result) {
        $conflict_data = pg_fetch_assoc($conflict_result);
        if ($conflict_data['conflict_count'] > 0) {
            echo "There is a confliction.";
            die();
        }
    } else {
        echo "Error checking for conflicts: " . pg_last_error($conn);
        die();
    }
?>

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
    <h1>Health Connect</h1>
    <div class="form-box">
        <form action="homepage_user.php" method="post">

            <!-- Your form fields here, including Doctor and Hour -->
            <input type="hidden" name="new_doctor" value="<?php echo $new_doctor; ?>">
            <input type="hidden" name="new_hour" value="<?php echo $new_hour; ?>">

            <p><input type="submit" /></p>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Ensure $_SESSION['id'] is set before using it in the query
            if (!isset($_SESSION['id'])) {
                die("User ID not set in the session.");
            }

            // Avoid SQL injection by using parameterized queries
            $make_query = "INSERT INTO Appointment (doctor_id, patient_id, hour, date) VALUES ($1, $2, $3, $4)";
            $result = pg_query_params($conn, $make_query, array(
                $new_doctor,
                $_SESSION['id'],
                $new_hour,
                $date
            ));

            if ($result) {
                echo "Appointment created successfully.<br/>";
            } else {
                echo "Error: " . $make_query . "<br>" . pg_last_error($conn);
            }
        }
        ?>
    </div>
</body>
</html>

<?php
    }

// Close the connection
pg_close($conn);
?>
