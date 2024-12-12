<?php
$conn = new mysqli("localhost", "root", "", "agentiedemobila");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = 10;
$new_color = "Bej";

$sql = "UPDATE mobila SET Culoare = ? WHERE Id_mobila = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_color, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Culoarea mobilei cu ID-ul $id a fost actualizată la '$new_color'.";
} else {
    echo "Nu s-a găsit mobilă cu ID-ul $id pentru actualizare.";
}

$conn->close();
?>
