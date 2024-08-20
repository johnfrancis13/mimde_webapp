<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Hello World!";

// Include the database connection file
require '../src/db/connection.php';

$sql = "SELECT TOP 10 id, response,qnum,mcq FROM dbo.test_annotations_draft WHERE annotators < 3 ORDER BY NEWID()";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch and store the results in an array
$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Encode the array to JSON and output it
header('Content-Type: application/json');
echo json_encode($data);

// Free statement and close connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>