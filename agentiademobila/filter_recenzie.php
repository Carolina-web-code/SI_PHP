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

$sql = "SELECT * FROM recenzii WHERE 
        Comentariu LIKE ? OR
        Rating LIKE ? OR
        Id_mobila LIKE ? OR
        Data_recenzie LIKE ?";
$stmt = $conn->prepare($sql);

$likeFilter = "%$filter%";
$stmt->bind_param("ssss", $likeFilter, $likeFilter, $likeFilter, $likeFilter);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Filtrare Recenzii</title>
</head>
<body>
    <h1>Filtrează Recenzii</h1>
    <div style="text-align: right; padding:20px;">
    <form method="GET">
        <input type="text" name="filter" placeholder="Filtrează după comentariu, rating, ID mobilă..." value="<?php echo htmlspecialchars($filter); ?>">
        <button type="submit">Filtrează</button>
    </form>
    <table border="1">
        <tr>
            <th>ID Client</th>
            <th>Rating</th>
            <th>Comentariu</th>
            <th>ID Mobilă</th>
            <th>Data Recenzie</th>
        </tr>
        </div>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Id_client']); ?></td>
                    <td><?php echo htmlspecialchars($row['Rating']); ?></td>
                    <td><?php echo htmlspecialchars($row['Comentariu']); ?></td>
                    <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                    <td><?php echo htmlspecialchars($row['Data_recenzie']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Nu există rezultate pentru filtrul specificat.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
