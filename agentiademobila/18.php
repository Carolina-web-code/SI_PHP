<?php
$conn = new mysqli("localhost", "root", "", "agentiedemobila");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$culoare = "Sur";

$sql = "SELECT COUNT(*) as total FROM mobila WHERE Culoare = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $culoare);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo "Număr total de mobilier cu culoarea '$culoare': " . $row['total'];
$conn->close();
?>
