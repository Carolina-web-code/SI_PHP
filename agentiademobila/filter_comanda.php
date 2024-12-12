<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$id_comanda = isset($_GET['id_comanda']) ? trim($_GET['id_comanda']) : '';
$client_id = isset($_GET['client_id']) ? trim($_GET['client_id']) : '';
$data_comanda = isset($_GET['data_comanda']) ? trim($_GET['data_comanda']) : '';
$id_mobila = isset($_GET['id_mobila']) ? trim($_GET['id_mobila']) : '';
$minPret = isset($_GET['min_pret']) ? (float)$_GET['min_pret'] : 0;
$maxPret = isset($_GET['max_pret']) ? (float)$_GET['max_pret'] : PHP_INT_MAX;

$sql = "SELECT * FROM comenzi WHERE Pret_total BETWEEN ? AND ?";
$params = ["dd", $minPret, $maxPret];

if (!empty($id_comanda)) {
    $sql .= " AND Id_comanda LIKE ?";
    $params[0] .= "s";
    $params[] = "%$id_comanda%";
}

if (!empty($client_id)) {
    $sql .= " AND Id_client LIKE ?";
    $params[0] .= "s";
    $params[] = "%$client_id%";
}

if (!empty($data_comanda)) {
    $sql .= " AND Data_comanda = ?";
    $params[0] .= "s";
    $params[] = $data_comanda;
}

if (!empty($id_mobila)) {
    $sql .= " AND Id_mobila LIKE ?";
    $params[0] .= "s";
    $params[] = "%$id_mobila%";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param(...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrare Comenzi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Filtrează Comenzi</h1>
<form method="GET">
    <label>ID Comandă:</label>
    <input type="text" name="id_comanda" value="<?php echo htmlspecialchars($id_comanda); ?>">
    
    <label>ID Client:</label>
    <input type="text" name="client_id" value="<?php echo htmlspecialchars($client_id); ?>">
    
    <label>Data Comandă:</label>
    <input type="date" name="data_comanda" value="<?php echo htmlspecialchars($data_comanda); ?>">
    
    <label>ID Mobilă:</label>
    <input type="text" name="id_mobila" value="<?php echo htmlspecialchars($id_mobila); ?>">
    
    <label>Preț minim:</label>
    <input type="number" name="min_pret" step="0.01" value="<?php echo htmlspecialchars($minPret); ?>">
    
    <label>Preț maxim:</label>
    <input type="number" name="max_pret" step="0.01" value="<?php echo htmlspecialchars($maxPret); ?>">
    
    <button type="submit">Filtrează</button>
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
            <td colspan="6">Nu există rezultate pentru criteriile selectate.</td>
        </tr>
    <?php endif; ?>
</table>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
