<?php  
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agentiedemobila';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['nume'], $_POST['prenume'], $_POST['telefon'], $_POST['email'], $_POST['adresa'])) {
        
    
        $nume = trim($_POST['nume']);
        $prenume = trim($_POST['prenume']);
        $telefon = trim($_POST['telefon']);
        $email = trim($_POST['email']);
        $adresa = trim($_POST['adresa']);

       
        if (empty($nume) || empty($prenume) || empty($telefon) || empty($email) || empty($adresa)) {
            die("Toate câmpurile sunt obligatorii.");
        }

       
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Email invalid.");
        }

        $check_sql = "SELECT * FROM clienti WHERE email = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            die("Un client cu acest email există deja.");
        } else {
    
            $sql = "INSERT INTO clienti (Nume, Prenume, Telefon, Email, Adresa) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nume, $prenume, $telefon, $email, $adresa);

            if ($stmt->execute()) {
                header('Location: afisare_clienti.php'); 
                exit();
            } else {
                echo "Eroare: " . $stmt->error;
            }
        }

        $stmt->close();
    } else {
        die("Datele din formular nu au fost trimise corect.");
    }
} else {
    die("Metoda de trimitere a formularului nu este POST.");
}

$conn->close();
?>