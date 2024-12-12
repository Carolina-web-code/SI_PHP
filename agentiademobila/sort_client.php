<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$allowedColumns = ['Nume', 'Prenume', 'Telefon', 'Email', 'Adresa'];

$order = isset($_GET['order']) && in_array($_GET['order'], $allowedColumns) ? $_GET['order'] : 'Nume';

$direction = isset($_GET['direction']) && in_array(strtoupper($_GET['direction']), ['ASC', 'DESC']) ? strtoupper($_GET['direction']) : 'ASC';

$nextDirection = $direction === 'ASC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM clienti ORDER BY $order $direction";
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
    <title>Sortează Clienți</title>
</head>
<body>
    <h1>Sortează Clienți</h1>
    <h3 style="text-align: center;">
        <a href="?order=Nume&direction=<?php echo $nextDirection; ?>">Sortează după Nume</a> | 
        <a href="?order=Prenume&direction=<?php echo $nextDirection; ?>">Sortează după Prenume</a> | 
        <a href="?order=Telefon&direction=<?php echo $nextDirection; ?>">Sortează după Telefon</a> | 
        <a href="?order=Email&direction=<?php echo $nextDirection; ?>">Sortează după Email</a> | 
        <a href="?order=Adresa&direction=<?php echo $nextDirection; ?>">Sortează după Adresă</a>
    </h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Telefon</th>
            <th>Email</th>
            <th>Adresă</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Id_client']); ?></td>
                <td><?php echo htmlspecialchars($row['Nume']); ?></td>
                <td><?php echo htmlspecialchars($row['Prenume']); ?></td>
                <td><?php echo htmlspecialchars($row['Telefon']); ?></td>
                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                <td><?php echo htmlspecialchars($row['Adresa']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
