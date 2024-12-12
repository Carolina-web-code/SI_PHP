<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$allowedColumns = ['Nume_furnizor', 'Telefon', 'Email', 'Adresa'];
$order = isset($_GET['order']) && in_array($_GET['order'], $allowedColumns) ? $_GET['order'] : 'Nume_furnizor';
$direction = isset($_GET['direction']) && in_array(strtoupper($_GET['direction']), ['ASC', 'DESC']) ? strtoupper($_GET['direction']) : 'ASC';
$nextDirection = $direction === 'ASC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM furnizori ORDER BY $order $direction";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sortează Furnizori</title>
</head>
<body>
    <h1>Sortează Furnizori</h1>
    <table border="1">
        <tr>
            <th><a href="?order=Nume_furnizor&direction=<?php echo $nextDirection; ?>">Nume</a></th>
            <th><a href="?order=Telefon&direction=<?php echo $nextDirection; ?>">Telefon</a></th>
            <th><a href="?order=Email&direction=<?php echo $nextDirection; ?>">Email</a></th>
            <th><a href="?order=Adresa&direction=<?php echo $nextDirection; ?>">Adresă</a></th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Nume_furnizor']); ?></td>
                    <td><?php echo htmlspecialchars($row['Telefon']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo htmlspecialchars($row['Adresa']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Nu există furnizori de afișat.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
