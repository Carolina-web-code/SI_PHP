<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$allowedColumns = ['Id_client', 'Data_comanda', 'Id_mobila', 'Cantitate', 'Pret_total'];

$order = isset($_GET['order']) && in_array($_GET['order'], $allowedColumns) ? $_GET['order'] : 'Data_comanda';

$direction = isset($_GET['direction']) && in_array(strtoupper($_GET['direction']), ['ASC', 'DESC']) ? strtoupper($_GET['direction']) : 'ASC';

$nextDirection = $direction === 'ASC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM comenzi ORDER BY $order $direction";
$result = $conn->query($sql);

if (!$result) {
    die("Eroare la interogare: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sortează Comenzi</title>
</head>
<body>
    <h1>Sortează Comenzi</h1>
    <h3 style="text-align: center;">
        <a href="?order=Id_client&direction=<?php echo $nextDirection; ?>">Sortează după ID Client</a> | 
        <a href="?order=Data_comanda&direction=<?php echo $nextDirection; ?>">Sortează după Data Comandă</a> | 
        <a href="?order=Id_mobila&direction=<?php echo $nextDirection; ?>">Sortează după ID Mobilă</a> | 
        <a href="?order=Cantitate&direction=<?php echo $nextDirection; ?>">Sortează după Cantitate</a> | 
        <a href="?order=Pret_total&direction=<?php echo $nextDirection; ?>">Sortează după Preț Total</a>
    </h3>
    <table border="1">
        <tr>
            <th>ID Comandă</th>
            <th>ID Client</th>
            <th>Data Comandă</th>
            <th>ID Mobilă</th>
            <th>Cantitate</th>
            <th>Preț Total</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Id_comanda']); ?></td>
                <td><?php echo htmlspecialchars($row['Id_client']); ?></td>
                <td><?php echo htmlspecialchars($row['Data_comanda']); ?></td>
                <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                <td><?php echo htmlspecialchars($row['Cantitate']); ?></td>
                <td><?php echo htmlspecialchars($row['Pret_total']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
