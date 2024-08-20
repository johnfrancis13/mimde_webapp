<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Hello World!";

// Include the database connection file
require '../src/db/connection.php';

$sql = "SELECT id, response,qnum,mcq FROM dbo.test_annotations_draft WHERE annotators < 3 LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIMDE Web App</title>
</head>
<body>
    <h1>Users List</h1>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li>ID: " . $row["id"]. " - Response: " . $row["response"].  "</li>";
        }
        echo "</ul>";
    } else {
        echo "0 results";
    }
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>