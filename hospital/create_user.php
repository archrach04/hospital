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
    $id = pg_escape_string($_POST["id"]);
    $pass = pg_escape_string($_POST["pass"]);
    $fname = pg_escape_string($_POST["fname"]);
    $lname = pg_escape_string($_POST["lname"]);

    // Check if the user already exists
    $check_user_sql = "SELECT username FROM Patient WHERE username = '$id'";
    $check_user_result = pg_query($conn, $check_user_sql);

    if (!$check_user_result) {
        echo "Error checking user: " . pg_last_error($conn);
        die();
    }

    $user_exists = pg_num_rows($check_user_result) > 0;

    if (!$user_exists) {
        // Insert the new user into the database
        $insert_user_sql = "INSERT INTO Patient (username, password, first_name, last_name) VALUES ('$id', '$pass', '$fname', '$lname')";
        $insert_result = pg_query($conn, $insert_user_sql);

        if ($insert_result) {
            echo "User registered successfully.";
            // You can redirect to a login page or any other page as needed
        } else {
            echo "Error registering user: " . pg_last_error($conn);
        }
    } else {
        echo "User already exists.";
    }

    // Redirect to the specified location
    header("Location: http://localhost/hospital/index.php");
    die();
}

// Close the PostgreSQL connection
pg_close($conn);
?>
</body>
</html>
