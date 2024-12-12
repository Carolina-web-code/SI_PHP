<?php
$conn = new mysqli("localhost", "root", "", "agentiedemobila");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$material = "Piele";

$sql = "SELECT SUM(Pret) as total_price FROM mobila WHERE Material = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $material);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo "Prețul total al mobilei din materialul '$material': " . $row['total_price'] . " lei.";
$conn->close();
?>
