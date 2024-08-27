<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../src/db/connection.php';

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'];
$qnums = $data['qnums'];

$sql = "UPDATE dbo.test_annotations_draft_v3 SET annotators = annotators + 1 WHERE id = ? and qnum = ?";

// Loop through each ID and QNUM and execute the prepared statement (increase annotators)
foreach ($ids as $index => $id) {
    $qnum = $qnums[$index];
    $params = array($id, $qnum);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

$sql = "UPDATE dbo.test_annotations_draft_v3 SET live = 0 WHERE id = ? and qnum = ?";

// Loop through each ID and QNUM and execute the prepared statement (release the live flag)
foreach ($ids as $index => $id) {
    $qnum = $qnums[$index];
    $params = array($id, $qnum);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}


echo "Records updated successfully";

// Close the connection
sqlsrv_close($conn);
?>
