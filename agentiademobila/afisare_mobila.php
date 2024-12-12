<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "agentiedemobila";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM mobila WHERE Id_mobila = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        header("Location: afisare_mobila.php");
        exit();
    } else {
        echo "Eroare la pregătirea comenzii SQL: " . $conn->error;
    }
}

$rezultate_pe_pagina = 5; 
$pagina_curenta = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_curenta < 1) $pagina_curenta = 1;

$offset = ($pagina_curenta - 1) * $rezultate_pe_pagina;

$sql_total = "SELECT COUNT(*) AS total_mobila FROM mobila";
$result_total = $conn->query($sql_total);
$total_mobila = $result_total->fetch_assoc()['total_mobila'];
$total_pagini = ceil($total_mobila / $rezultate_pe_pagina);

$sql = "SELECT Id_mobila, Material, Culoare, Dimensiuni, Pret FROM mobila LIMIT $offset, $rezultate_pe_pagina";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Afișare Mobilă</title>
</head>
<body>
    <div class="container">
        <h1>Lista Mobilei</h1>
        <table>
            <tr>
                <th>ID Mobilă</th>
                <th>Material</th>
                <th>Culoare</th>
                <th>Dimensiuni</th>
                <th>Preț</th>
                <th>Ștergere</th>
                <th>Editare</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Id_mobila']); ?></td>
                        <td><?php echo htmlspecialchars($row['Material']); ?></td>
                        <td><?php echo htmlspecialchars($row['Culoare']); ?></td>
                        <td><?php echo htmlspecialchars($row['Dimensiuni']); ?></td>
                        <td><?php echo htmlspecialchars($row['Pret']); ?></td>
                        <td>
                            <a href="afisare_mobila.php?delete_id=<?php echo htmlspecialchars($row['Id_mobila']); ?>" onclick="return confirm('Ești sigur că vrei să ștergi această mobilă?')">
                                <button>Șterge</button>
                            </a>
                        </td>
                        <td>
                            <a href="editare_mobila.php?id=<?php echo htmlspecialchars($row['Id_mobila']); ?>">
                                <button>Editează</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nu există mobilă disponibilă.</td>
                </tr>
            <?php endif; ?>
        </table>
        <form action="inregistrare_mobila.html" method="POST">
            <div style="padding-top: 20px;">
    <button type="submit">Adaugă o noua mobila</button></div>
</form>
<form action="procesare_mobila.php" method="POST">
<div style="padding-top: 20px;">
<label for="material">Material:</label>
            <input type="text" id="material" name="material" required>

            <label for="culoare">Culoare:</label>
            <input type="text" id="culoare" name="culoare" required>

            <label for="dimensiuni">Dimensiuni:</label>
            <input type="text" id="dimensiuni" name="dimensiuni" required>

            <label for="pret">Preț:</label>
            <input type="number" id="pret" name="pret" required>
    <div style="padding-top: 20px;">
    <button type="submit">Înregistrează</button></div>
</form>
    </div>
    <div class="paginare">
            <?php if ($pagina_curenta > 1): ?>
                <a href="afisare_mobila.php?pagina=<?php echo $pagina_curenta - 1; ?>">&laquo; Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pagini; $i++): ?>
                <?php if ($i == $pagina_curenta): ?>
                    <strong><?php echo $i; ?></strong>
                <?php else: ?>
                    <a href="afisare_mobila.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagina_curenta < $total_pagini): ?>
                <a href="afisare_mobila.php?pagina=<?php echo $pagina_curenta + 1; ?>">Următor &raquo;</a>
            <?php endif; ?>
        </div>
</body>
</html>

<?php
$conn->close();
?>
