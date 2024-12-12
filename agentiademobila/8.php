<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_mobila = 2;

$sql = "SELECT * FROM recenzii WHERE Id_mobila = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_mobila);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID Client: " . $row["Id_client"] . " - Rating: " . $row["Rating"] . " - Comentariu: " . $row["Comentariu"] . "<br>";
    }
} else {
    echo "Nu există recenzii pentru această mobilă.";
}

$conn->close();
?>
