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
    die("ID-ul comenzii este invalid.");
}
$comanda_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM comenzi WHERE Id_comanda = ?");
$stmt->bind_param("i", $comanda_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Comanda nu a fost găsită.");
}
$comanda = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_POST['client_id'];
    $data_comanda = $_POST['data_comanda'];
    $id_mobila = $_POST['id_mobila'];
    $cantitate = $_POST['cantitate'];
    $pret_total = $_POST['pret_total'];

    if (empty($client_id) || empty($data_comanda) || empty($id_mobila) || empty($cantitate) || empty($pret_total)) {
        echo "Toate câmpurile sunt obligatorii.";
    } else {
        $stmt = $conn->prepare("UPDATE comenzi SET Id_client = ?, Data_comanda = ?, Id_mobila = ?, Cantitate = ?, Pret_total = ? WHERE Id_comanda = ?");
        $stmt->bind_param("isisdi", $client_id, $data_comanda, $id_mobila, $cantitate, $pret_total, $comanda_id);

        if ($stmt->execute()) {
            header("Location: afisare_comanda.php");
            exit();
        } else {
            echo "Eroare la actualizare: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editare Comandă</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editare Comandă</h1>
        <form method="POST">
            <label for="client_id">ID Client:</label>
            <input type="number" name="client_id" value="<?= htmlspecialchars($comanda['Id_client']) ?>" required>

            <label for="data_comanda">Data Comandă:</label>
            <input type="date" name="data_comanda" value="<?= htmlspecialchars($comanda['Data_comanda']) ?>" required>

            <label for="id_mobila">ID Mobilă:</label>
            <input type="number" name="id_mobila" value="<?= htmlspecialchars($comanda['Id_mobila']) ?>" required>

            <label for="cantitate">Cantitate:</label>
            <input type="number" name="cantitate" value="<?= htmlspecialchars($comanda['Cantitate']) ?>" required>

            <label for="pret_total">Preț Total:</label>
            <input type="number" step="0.01" name="pret_total" value="<?= htmlspecialchars($comanda['Pret_total']) ?>" required>

            <button type="submit">Salvează modificările</button>
        </form>
        <a href="afisare_comanda.php"><button>Înapoi</button></a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
