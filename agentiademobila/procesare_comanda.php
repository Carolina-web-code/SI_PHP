<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agentiedemobila';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$client_id = trim($_POST['client_id']);
$data_comanda = trim($_POST['data_comanda']);
$id_mobila = trim($_POST['id_mobila']);
$cantitate = trim($_POST['cantitate']);
$pret_total = trim($_POST['pret_total']);

if (empty($client_id) || empty($data_comanda) || empty($id_mobila) || empty($cantitate) || empty($pret_total)) {
    die("Toate câmpurile sunt obligatorii.");
}

if (!is_numeric($client_id) || !is_numeric($id_mobila) || !is_numeric($cantitate) || !is_numeric($pret_total)) {
    die("Toate câmpurile trebuie să conțină valori valide.");
}

$verificare_sql = "SELECT * FROM comenzi WHERE Id_client = '$client_id' AND Data_comanda = '$data_comanda'";
$result = $conn->query($verificare_sql);

if ($result->num_rows > 0) {
    die("O comandă pentru acest client la această dată există deja.");
}

$sql = "INSERT INTO comenzi (Id_client, Data_comanda, Id_mobila, Cantitate, Pret_total) 
        VALUES ('$client_id', '$data_comanda', '$id_mobila', '$cantitate', '$pret_total')";

if ($conn->query($sql) === TRUE) {
    echo "Comanda a fost înregistrată cu succes!";
} else {
    echo "Eroare: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
