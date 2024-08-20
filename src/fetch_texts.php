<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "mimde.database.windows.net";
$username = "ai4ps_mimde";
$password = "what_is_yasp_123";
$dbname = "mimde_qualtrics";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT id, response,qnum,mcq FROM dbo.test_annotations_draft WHERE annotators < 3 LIMIT 10";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data[] = array("error" => "No results found");
}

// Return data in JSON format
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>