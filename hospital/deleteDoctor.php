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
    $old_doctor = $_POST["Old_Doctor"];

    $sql = "DELETE FROM Doctor WHERE id = '$old_doctor' ";

    $result = pg_query($conn, $sql);

    if ($result) {
        // Redirect to the specified location
        header("Location: http://localhost/hospital/admin.php");
        die();
    } else {
        echo "Error: " . $sql . "<br>" . pg_last_error($conn);
    }
}

pg_close($conn);
?>
</body>
</html>
