<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM recenzii WHERE Data_recenzie = '2024-01-15'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID Client: " . $row["Id_client"] . " - Rating: " . $row["Rating"] . " - Comentariu: " . $row["Comentariu"] . " - Data: " . $row["Data_recenzie"] . "<br>";
    }
} else {
    echo "Nu există recenzii pentru 2024-01-15.";
}

$conn->close();
?>
