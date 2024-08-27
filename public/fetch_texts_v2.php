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


// Encode the array to JSON and output it
echo json_encode($data);

sqlsrv_free_stmt($getResults);
sqlsrv_close($conn);

?>