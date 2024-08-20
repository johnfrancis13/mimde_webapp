<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Include the database connection file
require '../src/db/connection.php';

$tsql= "SELECT TOP 10 id, response,qnum,mcq FROM dbo.test_annotations_draft WHERE annotators < 3 ORDER BY NEWID()";
$getResults= sqlsrv_query($conn, $tsql);
// echo ("Reading data from table" . PHP_EOL);

if ($getResults === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch and store the results in an array
$data = array();
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}


// Encode the array to JSON and output it
echo json_encode($data);

sqlsrv_free_stmt($getResults);
sqlsrv_close($conn);

?>