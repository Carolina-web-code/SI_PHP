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
$category = isset($_GET['category']) ? $_GET['category'] : '';


$allowedCategories = ['Id_mobila','Material', 'Culoare', 'Dimensiuni', 'Pret'];
if (!in_array($category, $allowedCategories)) {
    $category = 'Material'; 
}

// Construire interogare SQL
$sql = "SELECT * FROM mobila WHERE $category LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = "%$searchTerm%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Căutare Mobilă</title>
</head>
<body>
    <h1>Căutare Mobilă</h1>
    <form method="GET">
        <select name="category">
        <option value="Id_mobila" <?php echo $category === 'Id_mobila' ? 'selected' : ''; ?>>Id_mobila</option>
            <option value="Material" <?php echo $category === 'Material' ? 'selected' : ''; ?>>Material</option>
            <option value="Culoare" <?php echo $category === 'Culoare' ? 'selected' : ''; ?>>Culoare</option>
            <option value="Dimensiuni" <?php echo $category === 'Dimensiuni' ? 'selected' : ''; ?>>Dimensiuni</option>
            <option value="Pret" <?php echo $category === 'Pret' ? 'selected' : ''; ?>>Preț</option>
        </select>
        <input type="text" name="search" placeholder="Caută mobilă..." value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Caută</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Material</th>
            <th>Culoare</th>
            <th>Dimensiuni</th>
            <th>Preț</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                    <td><?php echo htmlspecialchars($row['Material']); ?></td>
                    <td><?php echo htmlspecialchars($row['Culoare']); ?></td>
                    <td><?php echo htmlspecialchars($row['Dimensiuni']); ?></td>
                    <td><?php echo htmlspecialchars($row['Pret']); ?></td>
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
<?php
$stmt->close();
$conn->close();
?>
