<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../src/db/connection.php';

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'];

$sql = "UPDATE dbo.test_annotations_draft SET annotators = annotators + 1 WHERE id = ?";

// Initialize a prepared statement
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Loop through each ID and execute the prepared statement
    foreach ($ids as $id) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    echo "Records updated successfully";
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
