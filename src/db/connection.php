<?php
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

?>
