<?php
require '../src/db/connection.php';

$textID = $_POST['TextID'];
$sql = "UPDATE test1 SET annotators = annotators + 1 WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
