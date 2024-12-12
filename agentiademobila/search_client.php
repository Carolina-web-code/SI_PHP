<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}


$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';


$order = isset($_GET['order']) ? $_GET['order'] : 'Id_client';
$allowedOrders = ['Id_client', 'Nume', 'Prenume', 'Telefon', 'Email', 'Adresa'];
if (!in_array($order, $allowedOrders)) {
    $order = 'Id_client'; 
}


if (!empty($searchTerm) || $order !== 'Adresa') {
    $sql = "SELECT * FROM clienti WHERE $order LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeTerm = "%$searchTerm%";
    $stmt->bind_param("s", $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "<p>Vă rugăm să completați termenul de căutare dacă ați ales 'Adresă'.</p>";
    $result = null;  
}

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Căutare Clienți</title>
</head>
<body>
    <h1>Rezultatele căutării</h1>
    <div style="text-align: left; padding:20px;">
    <form method="GET">
        <input type="text" name="search" placeholder="Caută..." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <select name="order" required>
            <option value="Id_client" <?php echo $order === 'Id_client' ? 'selected' : ''; ?>>ID</option>
            <option value="Nume" <?php echo $order === 'Nume' ? 'selected' : ''; ?>>Nume</option>
            <option value="Prenume" <?php echo $order === 'Prenume' ? 'selected' : ''; ?>>Prenume</option>
            <option value="Telefon" <?php echo $order === 'Telefon' ? 'selected' : ''; ?>>Telefon</option>
            <option value="Email" <?php echo $order === 'Email' ? 'selected' : ''; ?>>Email</option>
            <option value="Adresa" <?php echo $order === 'Adresa' ? 'selected' : ''; ?>>Adresă</option>
        </select>
        <button type="submit">Caută</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Telefon</th>
            <th>Email</th>
            <th>Adresă</th>
        </tr>
        </div>
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
                <td colspan="6">Nu există rezultate pentru căutarea specificată.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
