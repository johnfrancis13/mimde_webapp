<?php
$servername = "sql110.infinityfree.com";
$username = "if0_37137136";
$password = "9R4ZAguA0R";
$dbname = "if0_37137136_ai4ps_annotation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$textID = $_POST['TextID'];
$sql = "UPDATE test1 SET annotators = annotators + 1 WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
