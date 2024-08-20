<?php
$servername = "mimde.database.windows.net";
$username = "ai4ps_mimde";
$password = "what_is_yasp_123";
$dbname = "mimde_qualtrics";

$serverName = "mimde.database.windows.net"; // update me
$connectionOptions = array(
    "Database" => "mimde_qualtrics", // update me
    "Uid" => "ai4ps_mimde", // update me
    "PWD" => "your_paswhat_is_yasp_123sword" // update me
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>
