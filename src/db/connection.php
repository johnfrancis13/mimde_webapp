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

// Check connection
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "Connected successfully";

?>
