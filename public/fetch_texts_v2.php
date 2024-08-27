<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Include the database connection file
require '../src/db/connection.php';

$tsql = "WITH GroupedRandom AS (
    SELECT id, response, qnum, mcq,
           ROW_NUMBER() OVER (PARTITION BY qnum ORDER BY NEWID()) as rn
    FROM dbo.final_annotation_db
    WHERE annotators < 3  AND (live = 0 OR locktime < DATEADD(minute, -30, GETDATE()))
), 
RandomQnum AS (
    SELECT DISTINCT TOP 1 qnum, NEWID() as random_id
    FROM GroupedRandom
    WHERE rn = 1
    ORDER BY random_id
),
RandomResponses AS (
    SELECT id, response, qnum, mcq,
           ROW_NUMBER() OVER (PARTITION BY qnum ORDER BY NEWID()) as rn
    FROM dbo.final_annotation_db
    WHERE annotators < 3  AND (live = 0 OR locktime < DATEADD(minute, -30, GETDATE())) AND qnum IN (SELECT qnum FROM RandomQnum)
)
SELECT id, response, qnum, mcq
FROM RandomResponses
WHERE rn <= 8;
";

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


// Now do the lockout
$ids = $data['id'];
$qnums = $data['qnum'];

$sqla = "UPDATE dbo.final_annotation_db SET live = 1 WHERE id = ? AND qnum = ?";

// Loop through each ID and QNUM and execute the prepared statement (lock out live ids)
foreach ($ids as $index => $id) {
    $qnum = $qnums[$index];
    $params = array($id, $qnum);
    $stmt = sqlsrv_query($conn, $sqla, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

$sqlb = "UPDATE dbo.final_annotation_db SET locktime = GETDATE() WHERE id = ? AND qnum = ? AND mcq = ?";

// Loop through each ID and QNUM and execute the prepared statement (set the time the ids were locked out)
foreach ($ids as $index => $id) {
    $qnum = $qnums[$index];
    $params = array($id, $qnum);
    $stmt = sqlsrv_query($conn, $sqlb, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Encode the array to JSON and output it
echo json_encode($data);

sqlsrv_free_stmt($getResults);
sqlsrv_close($conn);

?>