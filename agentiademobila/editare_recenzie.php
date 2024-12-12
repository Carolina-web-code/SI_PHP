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
    die("ID-ul recenziei este invalid.");
}
$recenzie_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM recenzii WHERE id_recenzie = ?");
$stmt->bind_param("i", $recenzie_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Recenzia nu a fost găsită.");
}
$recenzie = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $comentariu = $_POST['comentariu'];

    if (!is_numeric($rating) || $rating < 1 || $rating > 5 || empty($comentariu)) {
        echo "Datele introduse sunt invalide. Asigură-te că ratingul este între 1 și 5 și comentariul nu este gol.";
    } else {
        $stmt = $conn->prepare("UPDATE recenzii SET rating = ?, comentariu = ?, data_recenzie = CURDATE() WHERE id_recenzie = ?");
        $stmt->bind_param("isi", $rating, $comentariu, $recenzie_id);

        if ($stmt->execute()) {
            header("Location: afisare_recenzie.php");
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
    <title>Editare Recenzie</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editare Recenzie</h1>
        <form method="POST">
            <label for="rating">Rating:</label>
            <input type="number" name="rating" min="1" max="5" value="<?= htmlspecialchars($recenzie['rating']) ?>" required>

            <label for="comentariu">Comentariu:</label>
            <textarea name="comentariu" required><?= htmlspecialchars($recenzie['comentariu']) ?></textarea>

            <button type="submit">Salvează modificările</button>
        </form>
        <a href="afisare_recenzie.php"><button>Înapoi</button></a>
    </div>
</body>
</html>
<?php
$conn->close();
?>
