<?php
$dbhost = "localhost";
$port = "5432";
$dbname = "hospital";
$dbuser = "postgres";
$dbpass = "dam999";

// Connect to PostgreSQL
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
} else {
    $old_branch = pg_escape_string($_POST["Old_Branch"]);

    $sql = "DELETE FROM Branches WHERE id = '$old_branch' ";

    $result = pg_query($conn, $sql);

    if ($result) {
        // Redirect to the specified location
        header("Location: http://localhost/hospital/admin.php");
        die();
    } else {
        echo "Error: " . $sql . "<br>" . pg_last_error($conn);
    }
}

// Close the connection
pg_close($conn);
?>
</body>
</html>
