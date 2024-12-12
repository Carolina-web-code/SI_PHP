<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Id_mobila = 10;

$sql = "SELECT * FROM mobila WHERE Id_mobila = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Id_mobila);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $material = $row['Material'] ?? 'Necunoscut';
        $culoare = $row['Culoare'] ?? 'Necunoscut';
        $dimensiuni = $row['Dimensiuni'] ?? 'Necunoscut';
        $pret = $row['Pret'] ?? 'Necunoscut';

        echo "ID_mobila: " . $row['Id_mobila'] . " | Material: " . $material . " | Culoare: " . $culoare . " | Dimensiuni: " . $dimensiuni . " | Preț: " . $pret . "<br>";
    }
} else {
    echo "Nu există mobilier cu ID-ul $Id_mobila.";
}

$conn->close();
?>
