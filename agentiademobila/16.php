<?php

$conn = new mysqli("localhost", "root", "", "agentiedemobila");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$material = "Compozit";

echo "Materialul pe care încercăm să-l ștergem este: '$material' <br>";

$sql = "DELETE FROM mobila WHERE LOWER(TRIM(Material)) = LOWER(TRIM(?))";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $material);  // Legăm parametrii


$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Mobilierul cu materialul '$material' a fost șters.";
} else {
    echo "Nu s-a găsit mobilier cu materialul '$material' pentru ștergere.";
}

$conn->close();
?>
