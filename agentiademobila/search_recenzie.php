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

$order = isset($_GET['order']) ? $_GET['order'] : 'Id_recenzie';
$allowedOrders = ['Id_recenzie', 'Id_client', 'Id_mobila', 'Rating', 'Comentariu', 'Data_recenzie'];
if (!in_array($order, $allowedOrders)) {
    $order = 'Id_recenzie';
}

if (!empty($searchTerm) || $order !== 'Comentariu') {
    $sql = "SELECT * FROM recenzii WHERE $order LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeTerm = "%$searchTerm%";
    $stmt->bind_param("s", $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "<p>Vă rugăm să completați termenul de căutare dacă ați ales 'Comentariu'.</p>";
    $result = null;  
}

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Căutare Recenzii</title>
</head>
<body>
    <h1>Rezultatele căutării recenziilor</h1>
    <div style="text-align: left; padding:20px;">
    <form method="GET">
        <input type="text" name="search" placeholder="Caută..." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <select name="order" required>
            <option value="Id_recenzie" <?php echo $order === 'Id_recenzie' ? 'selected' : ''; ?>>ID Recenzie</option>
            <option value="Id_client" <?php echo $order === 'Id_client' ? 'selected' : ''; ?>>ID Client</option>
            <option value="Id_mobila" <?php echo $order === 'Id_mobila' ? 'selected' : ''; ?>>ID Mobilă</option>
            <option value="Rating" <?php echo $order === 'Rating' ? 'selected' : ''; ?>>Rating</option>
            <option value="Comentariu" <?php echo $order === 'Comentariu' ? 'selected' : ''; ?>>Comentariu</option>
            <option value="Data_recenzie" <?php echo $order === 'Data_recenzie' ? 'selected' : ''; ?>>Data Recenzie</option>
        </select>
        <button type="submit">Caută</button>
    </form>

    <table border="1">
        <tr>
            <th>ID Recenzie</th>
            <th>ID Client</th>
            <th>ID Mobilă</th>
            <th>Rating</th>
            <th>Comentariu</th>
            <th>Data Recenzie</th>
        </tr>
        </div>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Id_recenzie']); ?></td>
                    <td><?php echo htmlspecialchars($row['Id_client']); ?></td>
                    <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                    <td><?php echo htmlspecialchars($row['Rating']); ?></td>
                    <td><?php echo htmlspecialchars($row['Comentariu']); ?></td>
                    <td><?php echo htmlspecialchars($row['Data_recenzie']); ?></td>
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
