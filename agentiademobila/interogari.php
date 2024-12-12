<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

include('1.php');  // Afișează clienții pe strada
include('2.php');  // Afișează clienții cu prenumele Roxana
include('3.php');  // Actualizează clientul
include('4.php');  // Șterge clientul
include('5.php');  // Paginare clienți
?>
