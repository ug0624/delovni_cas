<?php

$servername = "localhost";
$username = "delovni_cas";
$password = "Delo?NE....12";
$dbname = "delovni_Cas";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
