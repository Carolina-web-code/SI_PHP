<?php
$conn = new mysqli("localhost", "root", "", "agentiedemobila");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$culoare = "Bej";

$sql = "SELECT * FROM mobila WHERE Culoare = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $culoare);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['Id_mobila'] . " | Material: " . $row['Material'] . " | Culoare: " . $row['Culoare'] . " | Dimensiuni: " . $row['Dimensiuni'] . " | Preț: " . $row['Pret'] . "<br>";
    }
} else {
    echo "Nu există mobilier cu culoarea '$culoare'.";
}
$conn->close();
?>
