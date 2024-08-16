<?php
// db_connection.php

$servername = "localhost";
$username = "root";
$password = "Tritolo98.";
$dbname = "RealWorldTycoon";

// Crea una connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la connessione
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
