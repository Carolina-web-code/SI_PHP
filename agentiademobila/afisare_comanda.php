<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$records_per_page = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

$total_result = $conn->query("SELECT COUNT(*) as total FROM comenzi");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

$total_pages = ceil($total_records / $records_per_page);

if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM comenzi WHERE Id_comanda = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        header("Location: afisare_comanda.php");
        exit();
    } else {
        echo "Eroare la pregătirea comenzii SQL: " . $conn->error;
    }
}

$sql = "SELECT * FROM comenzi LIMIT $offset, $records_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afișare Comenzi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Lista Comenzilor</h1>
        <table>
            <tr>
                <th>ID Comandă</th>
                <th>Data Comandă</th>
                <th>ID Client</th>
                <th>ID Mobilă</th>
                <th>Cantitate</th>
                <th>Preț Total</th>
                <th>Ștergere</th>
                <th>Editare</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Id_comanda']); ?></td>
                        <td><?php echo htmlspecialchars($row['Data_comanda']); ?></td>
                        <td><?php echo htmlspecialchars($row['Id_client']); ?></td>
                        <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                        <td><?php echo htmlspecialchars($row['Cantitate']); ?></td>
                        <td><?php echo htmlspecialchars($row['Pret_total']); ?></td>
                        <td>
                            <a href="afisare_comanda.php?delete_id=<?php echo htmlspecialchars($row['Id_comanda']); ?>" onclick="return confirm('Ești sigur că vrei să ștergi această comandă?')">
                                <button>Șterge</button>
                            </a>
                        </td>
                        <td>
                            <a href="editare_comanda.php?id=<?php echo htmlspecialchars($row['Id_comanda']); ?>">
                                <button>Editează</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Nu există comenzi disponibile.</td>
                </tr>
            <?php endif; ?>
        </table>
        <form action="inregistrare_comanda.html" method="POST">
            <div style="padding-top: 20px;">
    <button type="submit">Adaugă un nou client</button></div>
</form>
<form action="procesare_comanda.php" method="POST">
<div style="padding-top: 20px;">
<label for="client_id">ID Client:</label>
            <input type="number" id="client_id" name="client_id" required>

            <label for="data_comanda">Data Comandă:</label>
            <input type="date" id="data_comanda" name="data_comanda" required>

            <label for="id_mobila">ID Mobilă:</label>
            <input type="number" id="id_mobila" name="id_mobila" required>

            <label for="cantitate">Cantitate:</label>
            <input type="number" id="cantitate" name="cantitate" required>

            <label for="pret_total">Preț Total:</label>
            <input type="number" step="0.01" id="pret_total" name="pret_total" required>
    <div style="padding-top: 20px;">
    <button type="submit">Înregistrează</button></div>
</form>
    </div>
    <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="afisare_comanda.php?page=<?php echo $page - 1; ?>">Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="afisare_comanda.php?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="afisare_comanda.php?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
</body>
</html>

<?php
$conn->close();
?>
