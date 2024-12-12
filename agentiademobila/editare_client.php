<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    $sql = "SELECT * FROM clienti WHERE Id_client = ?";  
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        echo "Clientul nu a fost găsit.";
        exit();
    }
} else {
    echo "ID-ul clientului nu a fost furnizat.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $adresa = $_POST['adresa'];

    $update_sql = "UPDATE clienti SET Nume = ?, Prenume = ?, Telefon = ?, Email = ?, Adresa = ? WHERE Id_client = ?";  
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $nume, $prenume, $telefon, $email, $adresa, $client_id);
    
    if ($update_stmt->execute()) {
        header("Location: afisare_clienti.php"); 
        exit();
    } else {
        echo "Eroare la actualizarea datelor clientului: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editare Client</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editare Client</h1>

        <form method="POST" action="">
            <label for="nume">Nume:</label>
            <input type="text" name="nume" value="<?php echo htmlspecialchars($client['Nume']); ?>" required>

            <label for="prenume">Prenume:</label>
            <input type="text" name="prenume" value="<?php echo htmlspecialchars($client['Prenume']); ?>" required>

            <label for="telefon">Telefon:</label>
            <input type="text" name="telefon" value="<?php echo htmlspecialchars($client['Telefon']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($client['Email']); ?>" required>

            <label for="adresa">Adresă:</label>
            <input type="text" name="adresa" value="<?php echo htmlspecialchars($client['Adresa']); ?>" required>

            <button type="submit">Salvează modificările</button>
        </form>

        <a href="afisare_clienti.php"><button>Înapoi la lista de clienți</button></a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
