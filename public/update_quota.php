<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../src/db/connection.php';

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'];

$sql = "UPDATE dbo.test_annotations_draft SET annotators = annotators + 1 WHERE id = ?";

// Loop through each ID and execute the prepared statement
foreach ($ids as $id) {
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

echo "Records updated successfully";

// Close the connection
sqlsrv_close($conn);
?>
