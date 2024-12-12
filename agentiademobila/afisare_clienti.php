<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$perPage = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$startAt = $perPage * ($page - 1);

$totalQuery = "SELECT COUNT(*) as total FROM clienti";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalClients = $totalRow['total'];
$totalPages = ceil($totalClients / $perPage); 


if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql_delete_reviews = "DELETE FROM recenzii WHERE Id_client = ?";
    $stmt_reviews = $conn->prepare($sql_delete_reviews);
    if ($stmt_reviews) {
        $stmt_reviews->bind_param("i", $delete_id);
        $stmt_reviews->execute();
        $stmt_reviews->close();
    } else {
        echo "Eroare la ștergerea recenziilor: " . $conn->error;
        exit();
    }

    $sql = "DELETE FROM clienti WHERE Id_client = ?";  
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        header("Location: afisare_clienti.php");
        exit();
    } else {
        echo "Eroare la ștergerea clientului: " . $conn->error;
    }
}

$sql = "SELECT * FROM clienti LIMIT $startAt, $perPage";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Afișare Clienți</title>
</head>
<body>
    <div class="container">
        <h1>Lista Clienților</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Telefon</th>
                <th>Email</th>
                <th>Adresă</th>
                <th>Ștergere</th>
                <th>Editare</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Id_client']); ?></td> 
                        <td><?php echo htmlspecialchars($row['Nume']); ?></td>
                        <td><?php echo htmlspecialchars($row['Prenume']); ?></td>
                        <td><?php echo htmlspecialchars($row['Telefon']); ?></td>
                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        <td><?php echo htmlspecialchars($row['Adresa']); ?></td>
                        <td>
                            <a href="afisare_clienti.php?delete_id=<?php echo htmlspecialchars($row['Id_client']); ?>" onclick="return confirm('Ești sigur că vrei să ștergi acest client?')">
                                <button>Șterge</button>
                            </a>
                        </td>
                        <td>
                            <a href="editare_client.php?id=<?php echo htmlspecialchars($row['Id_client']); ?>"> 
                                <button>Editează</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Nu există clienți în baza de date.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    
     <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="afisare_clienti.php?page=<?php echo $page - 1; ?>">Anterior</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="afisare_clienti.php?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="afisare_clienti.php?page=<?php echo $page + 1; ?>">Următor</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
