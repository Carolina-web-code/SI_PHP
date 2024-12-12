<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$allowedColumns = ['Material', 'Culoare', 'Dimensiuni', 'Pret'];

$order = isset($_GET['order']) && in_array($_GET['order'], $allowedColumns) ? $_GET['order'] : 'Material';

$direction = isset($_GET['direction']) && in_array(strtoupper($_GET['direction']), ['ASC', 'DESC']) ? strtoupper($_GET['direction']) : 'ASC';

$nextDirection = $direction === 'ASC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM mobila ORDER BY $order $direction";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sortare Mobilă</title>
</head>
<body>
    <h1>Sortare Mobilă</h1>
    <br>
    <h3 style="text-align: center;">
        <a href="?order=Material&direction=<?php echo $nextDirection; ?>">Sortează după Material</a> | 
        <a href="?order=Culoare&direction=<?php echo $nextDirection; ?>">Sortează după Culoare</a> | 
        <a href="?order=Dimensiuni&direction=<?php echo $nextDirection; ?>">Sortează după Dimensiuni</a> | 
        <a href="?order=Pret&direction=<?php echo $nextDirection; ?>">Sortează după Preț</a>
    </h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Material</th>
            <th>Culoare</th>
            <th>Dimensiuni</th>
            <th>Preț</th>
        </tr> 
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                <td><?php echo htmlspecialchars($row['Material']); ?></td>
                <td><?php echo htmlspecialchars($row['Culoare']); ?></td>
                <td><?php echo htmlspecialchars($row['Dimensiuni']); ?></td>
                <td><?php echo htmlspecialchars($row['Pret']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
