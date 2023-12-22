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
    // Get values from the form
    $old_branch = $_POST["Old_Branch"];
    $name = $_POST["name"];

    // Update branch name in the database
    $sql = "UPDATE Branches SET name = '$name' WHERE id = '$old_branch'";
    $result = pg_query($conn, $sql);

    // Check if the update was successful
    if ($result) {
      echo "Branch updated successfully!";
    } else {
      echo "Error updating branch: " . pg_last_error($conn);
    }
  }

  // Close the database connection
  pg_close($conn);

  // Redirect to the admin page
  header("Location: http://localhost/hospital/admin.php");
  die();
?>
</body>
</html>
