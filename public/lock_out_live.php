<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../src/db/connection.php';

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'];
$qnums = $data['qnums'];
$mcqs = $data['mcqs'];

$sql = "UPDATE dbo.final_annotation_db SET live = 1 WHERE id = ? AND qnum = ? AND mcq = ?";

// Loop through each ID and QNUM and execute the prepared statement (lock out live ids)
foreach ($ids as $index => $id) {
    $qnum = $qnums[$index];
    $mcq = $mcqs[$index];
    $params = array($id, $qnum,$mcq);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

$sql = "UPDATE dbo.final_annotation_db SET locktime = GETDATE() WHERE id = ? AND qnum = ? AND mcq = ?";

// Loop through each ID and QNUM and execute the prepared statement (set the time the ids were locked out)
foreach ($ids as $index => $id) {
    $qnum = $qnums[$index];
    $mcq = $mcqs[$index];
    $params = array($id, $qnum,$mcq);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

echo "Records updated successfully";

// Close the connection
sqlsrv_close($conn);
?>
