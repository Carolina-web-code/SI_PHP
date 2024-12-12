<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$min_rating = isset($_GET['min_rating']) ? $_GET['min_rating'] : 3;

$sql = "SELECT * FROM recenzii WHERE Rating > ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $min_rating);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
   
        echo "ID Client: " . htmlspecialchars($row["Id_client"]) . " - Rating: " . htmlspecialchars($row["Rating"]) . " - Comentariu: " . htmlspecialchars($row["Comentariu"]) . "<br>";
    }
} else {
    echo "Nu există recenzii cu un rating mai mare decât " . $min_rating . ".";
}

$conn->close();
?>
