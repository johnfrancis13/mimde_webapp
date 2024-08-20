<?php
$serverName = "mimde.database.windows.net"; // update me
$connectionOptions = array(
    "Database" => "mimde_qualtrics", // update me
    "Uid" => "ai4ps_mimde", // update me
    "PWD" => "what_is_yasp_123" // update me
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

?>
