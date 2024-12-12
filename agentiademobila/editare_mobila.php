<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID-ul mobilei este invalid.");
}
$mobila_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM mobila WHERE Id_mobila = ?");
$stmt->bind_param("i", $mobila_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Mobila nu a fost găsită.");
}
$mobila = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $material = $_POST['material'];
    $culoare = $_POST['culoare'];
    $dimensiuni = $_POST['dimensiuni'];
    $pret = $_POST['pret'];

    if (empty($material) || empty($culoare) || empty($dimensiuni) || !is_numeric($pret) || $pret <= 0) {
        die("Datele introduse sunt invalide.");
    }

    $stmt = $conn->prepare("UPDATE mobila SET Material = ?, Culoare = ?, Dimensiuni = ?, Pret = ? WHERE Id_mobila = ?");
    $stmt->bind_param("sssdi", $material, $culoare, $dimensiuni, $pret, $mobila_id);

    if ($stmt->execute()) {
        header("Location: afisare_mobila.php");
        exit();
    } else {
        echo "Eroare la actualizare: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Editare Mobilă</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editare Mobilă</h1>
        <form method="POST">
            <label for="material">Material:</label>
            <input type="text" name="material" value="<?= htmlspecialchars($mobila['Material']) ?>" required>

            <label for="culoare">Culoare:</label>
            <input type="text" name="culoare" value="<?= htmlspecialchars($mobila['Culoare']) ?>" required>

            <label for="dimensiuni">Dimensiuni:</label>
            <input type="text" name="dimensiuni" value="<?= htmlspecialchars($mobila['Dimensiuni']) ?>" required>

            <label for="pret">Preț:</label>
            <input type="number" name="pret" value="<?= htmlspecialchars($mobila['Pret']) ?>" required>

            <button type="submit">Salvează modificările</button>
        </form>
        <a href="afisare_mobila.php"><button>Înapoi</button></a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
