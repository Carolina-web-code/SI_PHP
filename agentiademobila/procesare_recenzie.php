<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agentiedemobila';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$Id_client = trim($_POST['client_id']);
$rating = trim($_POST['rating']);
$comentariu = trim($_POST['comentariu']);
$Id_mobila = trim($_POST['id_mobila']);
$data_recenzie = trim($_POST['data_recenzie']);

if (empty($Id_client) || empty($rating) || empty($comentariu) || empty($Id_mobila) || empty($data_recenzie)) {
    die("Toate câmpurile sunt obligatorii.");
}

if (!is_numeric($Id_client) || !is_numeric($Id_mobila) || !is_numeric($rating) || $rating < 1 || $rating > 5) {
    die("ID-urile trebuie să fie numere valide, iar ratingul trebuie să fie între 1 și 5.");
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_recenzie)) {
    die("Data trebuie să fie într-un format valid (YYYY-MM-DD).");
}

$check_sql = "SELECT * FROM recenzii WHERE Id_client = ? AND Id_mobila = ? AND Data_recenzie = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("iis", $Id_client, $Id_mobila, $data_recenzie);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Această recenzie pentru această mobilă a fost deja înregistrată pentru data selectată.");
} else {
    $sql = "INSERT INTO recenzii (Id_client, Rating, Comentariu, Id_mobila, Data_recenzie) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisis", $Id_client, $rating, $comentariu, $Id_mobila, $data_recenzie);

    if ($stmt->execute() === TRUE) {
        echo "Recenzia a fost înregistrată cu succes!";
    } else {
        echo "Eroare la înregistrarea recenziei: " . $conn->error;
    }
}
$stmt->close();
$conn->close();
?>
