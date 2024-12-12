<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Id_client = 1; 

$Nume = "marian";
$Prenume = "ionescu"; 
$Telefon = "123456789"; 

$Nume = ucwords($Nume);
$Prenume = ucwords($Prenume);

$sql_update = "UPDATE clienti SET Nume = ?, Prenume = ?, Telefon = ? WHERE Id_client = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param("sssi", $Nume, $Prenume, $Telefon, $Id_client);
$stmt->execute();

$updateMessage = "Actualizat numele clientului cu ID-ul $Id_client!";
$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizare Client</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Rezultatul actualizării clientului</h1>
        <p><?php echo $updateMessage; ?></p>
    </div>
</body>
</html>

