<?php
$client_id = 6; 

echo "<h1>Recenzii pentru Clientul ID: " . htmlspecialchars($client_id) . "</h1>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$sql = "SELECT * FROM recenzii WHERE Id_client = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table class='recenzii-table'>";
    echo "<tr><th>ID Client</th><th>Rating</th><th>Comentariu</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["Id_client"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Rating"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Comentariu"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Nu există recenzii pentru acest client.</p>";
}

$conn->close();
?>
