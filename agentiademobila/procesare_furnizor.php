<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agentiedemobila';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$nume_furnizor = trim($_POST['nume_furnizor']);
$telefon = trim($_POST['telefon']);
$email = trim($_POST['email']);
$adresa = trim($_POST['adresa']);

if (empty($nume_furnizor) || empty($telefon)) {
    die("Toate câmpurile obligatorii trebuie completate (nume furnizor și telefon).");
}

if (!preg_match('/^[0-9]{10,15}$/', $telefon)) {
    die("Numărul de telefon nu este valid. Introduceți un număr de telefon valid.");
}

$check_sql = "SELECT * FROM furnizori WHERE nume_furnizor = '$nume_furnizor' OR telefon = '$telefon'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    die("Furnizorul există deja în baza de date, fie cu același nume, fie cu același număr de telefon.");
}

$sql = "INSERT INTO furnizori (Nume_furnizor, Telefon, Email, Adresa) 
        VALUES ('$nume_furnizor', '$telefon', '$email', '$adresa')";

if ($conn->query($sql) === TRUE) {
    echo "Furnizorul a fost înregistrat cu succes!";
} else {
    echo "Eroare: " . $conn->error;
}

$conn->close();
?>
