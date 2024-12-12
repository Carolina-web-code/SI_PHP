<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_select = "SELECT * FROM mobila";
$stmt = $conn->prepare($sql_select);
$stmt->execute();
$result = $stmt->get_result();

$mobila = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mobila .= "ID Mobilă: " . htmlspecialchars($row['Id_mobila']) . 
                   ", Material: " . htmlspecialchars($row['Material']) . 
                   ", Culoare: " . htmlspecialchars($row['Culoare']) . 
                   ", Dimensiuni: " . htmlspecialchars($row['Dimensiuni']) . 
                   ", Preț: " . htmlspecialchars($row['Pret']) . "<br>";

        if ($row['Pret'] > 2000) {
            $mobila .= " (Prețul este mai mare de 2000 lei)<br>";
        }
    }
} else {
    $mobila = "Nu există mobilă cu preț mai mare de 2000 de lei.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afisare Mobilă</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Lista Mobilei cu Preț mai Mare de 2000 Lei</h1>
        <div class="mobila-list">
            <?php echo $mobila; ?>
        </div>
    </div>
</body>
</html>
