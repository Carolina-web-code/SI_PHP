<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agentiedemobila';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $furnizor_id = $_GET['id'];
    $sql = "SELECT * FROM furnizori WHERE Id_furnizor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $furnizor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $furnizor = $result->fetch_assoc();
    $stmt->close();
} else {
    die("ID-ul furnizorului nu este valid.");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume_furnizor = trim($_POST['nume_furnizor']);
    $telefon = trim($_POST['telefon']);
    $email = trim($_POST['email']);
    $adresa = trim($_POST['adresa']);

    $update_sql = "UPDATE furnizori SET Nume_furnizor = ?, Telefon = ?, Email = ?, Adresa = ? WHERE Id_furnizor = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssi", $nume_furnizor, $telefon, $email, $adresa, $furnizor_id);

    if ($stmt->execute()) {
        echo "Furnizorul a fost actualizat cu succes!";
    } else {
        echo "Eroare la actualizarea furnizorului: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editare Furnizor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editare Furnizor</h1>
        <form action="editare_furnizor.php?id=<?php echo $furnizor_id; ?>" method="POST">
            <label for="nume_furnizor">Nume Furnizor:</label>
            <input type="text" id="nume_furnizor" name="nume_furnizor" value="<?php echo htmlspecialchars($furnizor['Nume_furnizor']); ?>" required>

            <label for="telefon">Telefon:</label>
            <input type="text" id="telefon" name="telefon" value="<?php echo htmlspecialchars($furnizor['Telefon']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($furnizor['Email']); ?>">

            <label for="adresa">Adresă:</label>
            <input type="text" id="adresa" name="adresa" value="<?php echo htmlspecialchars($furnizor['Adresa']); ?>">
       
            <button type="submit">Salvează modificările</button>
        </form>
        <a href="afisare_furnizor.php"><button>Înapoi</button></a>
    </div>
</body>
</html>
