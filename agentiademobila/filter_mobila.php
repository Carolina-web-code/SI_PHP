<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? trim($_GET['id']) : '';
$material = isset($_GET['material']) ? trim($_GET['material']) : '';
$culoare = isset($_GET['culoare']) ? trim($_GET['culoare']) : '';
$dimensiuni = isset($_GET['dimensiuni']) ? trim($_GET['dimensiuni']) : '';
$minPret = isset($_GET['min_pret']) ? (float)$_GET['min_pret'] : 0;
$maxPret = isset($_GET['max_pret']) ? (float)$_GET['max_pret'] : PHP_INT_MAX;

$sql = "SELECT * FROM mobila WHERE Pret BETWEEN ? AND ?";
$params = ["dd", $minPret, $maxPret];

if (!empty($id)) {
    $sql .= " AND Id_mobila LIKE ?";
    $params[0] .= "s";
    $params[] = "%$id%";
}

if (!empty($material)) {
    $sql .= " AND Material LIKE ?";
    $params[0] .= "s";
    $params[] = "%$material%";
}

if (!empty($culoare)) {
    $sql .= " AND Culoare LIKE ?";
    $params[0] .= "s";
    $params[] = "%$culoare%";
}

if (!empty($dimensiuni)) {
    $sql .= " AND Dimensiuni LIKE ?";
    $params[0] .= "s";
    $params[] = "%$dimensiuni%";
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
    <link rel="stylesheet" href="styles.css">
    <title>Filtrare Mobilă</title>
</head>
<body>
<h1>Filtrează Mobila</h1>
<br>
<form method="GET" style="text-align: center;">
     
        <div style="display: inline-block; margin-right: 10px;">
            <label style="font-weight: bold;">ID Mobilă:</label>
            <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" style="padding: 8px; width: 150px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="display: inline-block; margin-right: 10px;">
            <label style="font-weight: bold;">Material:</label>
            <input type="text" name="material" value="<?php echo htmlspecialchars($material); ?>" style="padding: 8px; width: 150px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="display: inline-block; margin-right: 10px;">
            <label style="font-weight: bold;">Culoare:</label>
            <input type="text" name="culoare" value="<?php echo htmlspecialchars($culoare); ?>" style="padding: 8px; width: 150px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="display: inline-block;">
            <label style="font-weight: bold;">Dimensiuni:</label>
            <input type="text" name="dimensiuni" value="<?php echo htmlspecialchars($dimensiuni); ?>" style="padding: 8px; width: 150px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <br><br>
     
        <div style="display: inline-block; margin-right: 10px;">
            <label style="font-weight: bold;">Preț minim:</label>
            <input type="number" name="min_pret" step="0.01" value="<?php echo htmlspecialchars($minPret); ?>" style="padding: 8px; width: 150px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="display: inline-block; margin-right: 10px;">
            <label style="font-weight: bold;">Preț maxim:</label>
            <input type="number" name="max_pret" step="0.01" value="<?php echo htmlspecialchars($maxPret); ?>" style="padding: 8px; width: 150px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <br><br><br>

        <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Filtrează</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Material</th>
            <th>Culoare</th>
            <th>Dimensiuni</th>
            <th>Preț</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
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
                <td colspan="5">Nu există rezultate pentru criteriile selectate.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
