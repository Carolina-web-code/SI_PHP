<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$allowedColumns = ['Rating', 'Comentariu', 'Id_mobila', 'Data_recenzie'];

$order = isset($_GET['order']) && in_array($_GET['order'], $allowedColumns) ? $_GET['order'] : 'Data_recenzie';

$direction = isset($_GET['direction']) && in_array(strtoupper($_GET['direction']), ['ASC', 'DESC']) ? strtoupper($_GET['direction']) : 'ASC';

$nextDirection = $direction === 'ASC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM recenzii ORDER BY $order $direction";
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
    <title>Sortează Recenzii</title>
</head>
<body>
    <h1>Sortează Recenzii</h1>
    <h3 style="text-align: center;">
        <a href="?order=Rating&direction=<?php echo $nextDirection; ?>">Sortează după Rating</a> | 
        <a href="?order=Comentariu&direction=<?php echo $nextDirection; ?>">Sortează după Comentariu</a> | 
        <a href="?order=Id_mobila&direction=<?php echo $nextDirection; ?>">Sortează după ID Mobilă</a> | 
        <a href="?order=Data_recenzie&direction=<?php echo $nextDirection; ?>">Sortează după Data Recenzie</a>
    </h3>
    <table border="1">
        <tr>
            <th>ID Client</th>
            <th>Rating</th>
            <th>Comentariu</th>
            <th>ID Mobilă</th>
            <th>Data Recenzie</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Id_client']); ?></td>
                <td><?php echo htmlspecialchars($row['Rating']); ?></td>
                <td><?php echo htmlspecialchars($row['Comentariu']); ?></td>
                <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                <td><?php echo htmlspecialchars($row['Data_recenzie']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
