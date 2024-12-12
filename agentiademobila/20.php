<?php
$conn = new mysqli("localhost", "root", "", "agentiedemobila");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pattern = "%100x%"; 

$sql = "SELECT * FROM mobila WHERE Dimensiuni LIKE ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pattern);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['Id_mobila'] . " | Material: " . $row['Material'] . " | Culoare: " . $row['Culoare'] . " | Dimensiuni: " . $row['Dimensiuni'] . " | Preț: " . $row['Pret'] . "<br>";
    }
} else {
    echo "Nu există mobilier cu dimensiuni ce conțin '100x'.";
}
$conn->close();
?>
