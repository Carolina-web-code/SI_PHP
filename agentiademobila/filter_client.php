<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$filter = isset($_GET['filter']) ? trim($_GET['filter']) : '';

$sql = "SELECT * FROM clienti WHERE 
    Id_client LIKE ? OR 
    Nume LIKE ? OR 
    Prenume LIKE ? OR 
    Telefon LIKE ? OR 
    Email LIKE ? OR 
    Adresa LIKE ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Eroare la pregătirea interogării: " . $conn->error);
}

$likeFilter = "%$filter%";
$stmt->bind_param("ssssss", $likeFilter, $likeFilter, $likeFilter, $likeFilter, $likeFilter, $likeFilter);

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Filtrare Clienți</title>
</head>
<body>
    <h1>Filtrează Clienți</h1>
    <div style="text-align: right; padding:20px;">
        <form method="GET">
            <input type="text" name="filter" placeholder="Caută după nume, prenume sau adresă..." value="<?php echo htmlspecialchars($filter); ?>">
            <button type="submit">Filtrează</button> 
        </form>
    </div>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Telefon</th>
            <th>Email</th>
            <th>Adresă</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
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
        <?php else: ?>
            <tr>
                <td colspan="6">Nu există rezultate pentru filtrul specificat.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
