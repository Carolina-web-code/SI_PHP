<?php
$conn = new mysqli("localhost", "root", "", "agentiedemobila");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = 10;

$sql = "UPDATE mobila SET Pret = Pret * 0.9 WHERE Id_mobila = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Prețul mobilei cu ID-ul $id a fost redus cu 10%.";
} else {
    echo "Nu s-a găsit mobilier cu ID-ul $id.";
}

$conn->close();
?>
