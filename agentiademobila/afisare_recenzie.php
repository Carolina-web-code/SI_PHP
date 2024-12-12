<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "agentiedemobila";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}


$rezultate_pe_pagina = 5; 
$pagina_curenta = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_curenta - 1) * $rezultate_pe_pagina;


$sql_total = "SELECT COUNT(*) AS total_recenzii FROM recenzii";
$result_total = $conn->query($sql_total);
$total_recenzii = $result_total->fetch_assoc()['total_recenzii'];
$total_pagini = ceil($total_recenzii / $rezultate_pe_pagina);


if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM recenzii WHERE Id_recenzie = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        header("Location: afisare_recenzie.php");
        exit();
    } else {
        echo "Eroare la pregătirea comenzii SQL: " . $conn->error;
    }
}

$sql = "SELECT Id_recenzie, Id_mobila, Id_client, Rating, Comentariu, Data_recenzie 
        FROM recenzii 
        LIMIT $offset, $rezultate_pe_pagina";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Afișare Recenzii</title>
</head>
<body>
    <div class="container">
        <h1>Lista Recenziilor</h1>
        <table>
            <tr>
                <th>ID Recenzie</th>
                <th>ID Mobilă</th>
                <th>ID Client</th>
                <th>Rating</th>
                <th>Comentariu</th>
                <th>Data Recenzie</th>
                <th>Ștergere</th>
                <th>Editare</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Id_recenzie']); ?></td>
                        <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                        <td><?php echo htmlspecialchars($row['Id_client']); ?></td>
                        <td><?php echo htmlspecialchars($row['Rating']); ?></td>
                        <td><?php echo htmlspecialchars($row['Comentariu']); ?></td>
                        <td><?php echo htmlspecialchars($row['Data_recenzie']); ?></td>
                        <td>
                            <a href="afisare_recenzie.php?delete_id=<?php echo htmlspecialchars($row['Id_recenzie']); ?>" onclick="return confirm('Ești sigur că vrei să ștergi această recenzie?')">
                                <button>Șterge</button>
                            </a>
                        </td>
                        <td>
                            <a href="editare_recenzie.php?id=<?php echo htmlspecialchars($row['Id_client']); ?>"> <!-- Folosește Id_client -->
                                <button>Editează</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nu există recenzii disponibile.</td>
                </tr>
            <?php endif; ?>
        </table>
        <form action="inregistrare_recenzie.html" method="POST">
            <div style="padding-top: 20px;">
    <button type="submit">Adaugă o noua recenzie</button></div>
</form>
<form action="procesare_recenzie.php" method="POST">
<div style="padding-top: 20px;">
            <label for="client_id">ID Client:</label>
            <input type="number" id="client_id" name="client_id" required>

            <label for="rating">Rating:</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>

            <label for="comentariu">Comentariu:</label>
            <textarea id="comentariu" name="comentariu" required></textarea>
             
            <label for="id_mobila">ID Mobilă:</label>
            <input type="number" id="id_mobila" name="id_mobila" required>

            <label for="data_recenzie">Data Recenzie:</label>
            <input type="date" id="data_recenzie" name="data_recenzie" value="<?php echo date('Y-m-d'); ?>" required>
    <div style="padding-top: 20px;">
    <button type="submit">Înregistrează</button></div>
</form>

    </div>
    <div class="paginare">
        <?php for ($i = 1; $i <= $total_pagini; $i++): ?>
            <?php if ($i == $pagina_curenta): ?>
                <strong><?php echo $i; ?></strong>
            <?php else: ?>
                <a href="afisare_recenzie.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
</body>
</html>

</body>
</html>

<?php
$conn->close();
?>
