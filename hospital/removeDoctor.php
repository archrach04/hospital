<?php
$dbhost = "localhost";
$port = "5432";
$dbname = "hospital";
$dbuser = "postgres";
$dbpass = "dam999";

// Connect to PostgreSQL
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted
    if (isset($_POST['Old_Doctor'])) {
        $doctorIdToRemove = $_POST['Old_Doctor'];

        // Remove the doctor from the database
        $deleteDoctorQuery = "DELETE FROM Doctor WHERE id = $doctorIdToRemove";
        $deleteDoctorResult = pg_query($conn, $deleteDoctorQuery);

        if (!$deleteDoctorResult) {
            echo "Error deleting doctor: " . pg_last_error();
        }
    }
}

?>

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

<h1>Health Connect</h1>

<form action="deleteDoctor.php" method="post">
    <h2>Add a Doctor</h2>
    <select name="Old_Doctor">
        <?php
        $id_doctor_query = "SELECT id, fname, lname FROM Doctor";
        $id_result = pg_query($conn, $id_doctor_query);
        while ($row2 = pg_fetch_assoc($id_result)) {
            echo "<option value='" . $row2['id'] . "'>" . $row2['fname'] . " " . $row2['lname'] . "</option>";
        }
        ?>
    </select>

    <p><input type="submit" value="Remove Doctor" /></p>
</form>

<br />

<?php
// Close the PostgreSQL connection
pg_close($conn);
?>
</body>
</html>
