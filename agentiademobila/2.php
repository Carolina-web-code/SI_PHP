<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_select_by_name = "SELECT * FROM clienti WHERE prenume = ?";
$prenume = 'Roxana';
$stmt = $conn->prepare($sql_select_by_name);
$stmt->bind_param("s", $prenume);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clienți cu Prenumele Roxana</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Clienți găsiți cu Prenumele Roxana</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
    
                echo "<div class='client-info'>";
                echo "<p><strong>Nume:</strong> " . htmlspecialchars($row['Nume']) . "</p>";
                echo "<p><strong>Prenume:</strong> " . htmlspecialchars($row['Prenume']) . "</p>";
                echo "<p><strong>Adresă:</strong> " . htmlspecialchars($row['Adresa']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Nu au fost găsiți clienți cu prenumele Roxana.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
