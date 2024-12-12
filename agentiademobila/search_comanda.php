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

$order = isset($_GET['order']) ? $_GET['order'] : 'Id_comanda';
$allowedOrders = ['Id_comanda', 'Id_client', 'Data_comanda', 'Id_mobila', 'Cantitate', 'Pret_total'];
if (!in_array($order, $allowedOrders)) {
    $order = 'Id_comanda'; 
}

if (!empty($searchTerm) || $order !== 'Pret_total') {
    $sql = "SELECT * FROM comenzi WHERE $order LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeTerm = "%$searchTerm%";
    $stmt->bind_param("s", $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "<p>Vă rugăm să completați termenul de căutare dacă ați ales 'Preț Total'.</p>";
    $result = null;  
}

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Căutare Comenzi</title>
</head>
<body>
    <h1>Rezultatele căutării</h1>
    <div style="text-align: left; padding:20px;">
    <form method="GET">
        <input type="text" name="search" placeholder="Caută..." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <select name="order" required>
            <option value="Id_comanda" <?php echo $order === 'Id_comanda' ? 'selected' : ''; ?>>ID Comandă</option>
            <option value="Id_client" <?php echo $order === 'Id_client' ? 'selected' : ''; ?>>ID Client</option>
            <option value="Data_comanda" <?php echo $order === 'Data_comanda' ? 'selected' : ''; ?>>Data Comandă</option>
            <option value="Id_mobila" <?php echo $order === 'Id_mobila' ? 'selected' : ''; ?>>ID Mobilă</option>
            <option value="Cantitate" <?php echo $order === 'Cantitate' ? 'selected' : ''; ?>>Cantitate</option>
            <option value="Pret_total" <?php echo $order === 'Pret_total' ? 'selected' : ''; ?>>Preț Total</option>
        </select>
        <button type="submit">Caută</button>
    </form>

    <table border="1">
        <tr>
            <th>ID Comandă</th>
            <th>ID Client</th>
            <th>Data Comandă</th>
            <th>ID Mobilă</th>
            <th>Cantitate</th>
            <th>Preț Total</th>
        </tr>
        </div>
        <?php if ($result && $result->num_rows > 0): ?>
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
