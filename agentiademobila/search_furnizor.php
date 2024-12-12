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
$order = isset($_GET['order']) ? $_GET['order'] : 'Id_furnizor';
$allowedOrders = ['Id_furnizor', 'Nume_furnizor', 'Telefon', 'Email', 'Adresa'];

if (!in_array($order, $allowedOrders)) {
    $order = 'Id_furnizor';
}

$sql = "SELECT * FROM furnizori WHERE $order LIKE ?";
$stmt = $conn->prepare($sql);
$likeTerm = "%$searchTerm%";
$stmt->bind_param("s", $likeTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Căutare Furnizori</title>
</head>
<body>
    <h1>Rezultatele căutării</h1>
    <form method="GET">
        <input type="text" name="search" placeholder="Caută..." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <select name="order" required>
            <?php foreach ($allowedOrders as $column): ?>
                <option value="<?php echo $column; ?>" <?php echo $order === $column ? 'selected' : ''; ?>>
                    <?php echo $column; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Caută</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nume Furnizor</th>
            <th>Telefon</th>
            <th>Email</th>
            <th>Adresă</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Id_furnizor']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nume_furnizor']); ?></td>
                    <td><?php echo htmlspecialchars($row['Telefon']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo htmlspecialchars($row['Adresa']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Nu există rezultate pentru căutarea specificată.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
