<?php  
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agentiedemobila';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$material = trim($_POST['material']);
$culoare = trim($_POST['culoare']);
$dimensiuni = trim($_POST['dimensiuni']);
$pret = trim($_POST['pret']);

if (empty($material) || empty($culoare) || empty($dimensiuni) || empty($pret)) {
    die("Toate câmpurile sunt obligatorii.");
}

if (!is_numeric($pret) || $pret <= 0) {
    die("Prețul trebuie să fie un număr valid și pozitiv.");
}

$check_sql = "SELECT * FROM mobila WHERE Material = ? AND Pret = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("sd", $material, $pret);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Mobila cu acest material și preț există deja.");
} else {
   
    $insert_sql = "INSERT INTO mobila (Material, Culoare, Dimensiuni, Pret) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sssd", $material, $culoare, $dimensiuni, $pret);

    if ($stmt->execute() === TRUE) {
        echo "Mobila a fost înregistrată cu succes!";
    } else {
        echo "Eroare la înregistrarea mobilei: " . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>
