<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agentiedemobila';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$records_per_page = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

$total_result = $conn->query("SELECT COUNT(*) as total FROM furnizori");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

$total_pages = ceil($total_records / $records_per_page);

$sql = "SELECT * FROM furnizori LIMIT $offset, $records_per_page";
$result = $conn->query($sql);
?>
<?php

if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM furnizori WHERE Id_furnizor = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        header("Location: afisare_furnizor.php");
        exit();
    } else {
        echo "Eroare la pregătirea comenzii SQL: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afișare Furnizori</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Lista Furnizorilor</h1>
        <table>
            <tr>
                <th>ID Furnizor</th>
                <th>Nume Furnizor</th>
                <th>Telefon</th>
                <th>Email</th>
                <th>Adresă</th>
                <th>Ștergere</th>
                <th>Editare</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Id_furnizor']); ?></td>
                        <td><?php echo htmlspecialchars($row['Nume_furnizor']); ?></td>
                        <td><?php echo htmlspecialchars($row['Telefon']); ?></td>
                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        <td><?php echo htmlspecialchars($row['Adresa']); ?></td>
                        <td>
                            <a href="afisare_furnizor.php?delete_id=<?php echo htmlspecialchars($row['Id_furnizor']); ?>" onclick="return confirm('Ești sigur că vrei să ștergi acest furnizor?')">
                                <button>Șterge</button>
                            </a>
                        </td>
                        <td>
                            <a href="editare_furnizor.php?id=<?php echo htmlspecialchars($row['Id_furnizor']); ?>">
                                <button>Editează</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nu există furnizori disponibili.</td>
                </tr>
            <?php endif; ?>
        </table>
        <form action="inregistrare_furnizor.html" method="POST">
            <div style="padding-top: 20px;">
    <button type="submit">Adaugă un nou furnizor</button></div>
</form>
<form action="procesare_furnizor.php" method="POST">
            <label for="nume_furnizor">Nume Furnizor:</label>
            <input type="text" id="nume_furnizor" name="nume_furnizor" required>

            <label for="telefon">Telefon:</label>
            <input type="text" id="telefon" name="telefon" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="adresa">Adresă:</label>
            <input type="text" id="adresa" name="adresa">
    <div style="padding-top: 20px;">
    <button type="submit">Înregistrează</button></div>
</form>
</div>
<div class="pagination">
            <?php if ($page > 1): ?>
                <a href="afisare_furnizor.php?page=<?php echo $page - 1; ?>">Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="afisare_furnizor.php?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="afisare_furnizor.php?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
</body>
</html>

