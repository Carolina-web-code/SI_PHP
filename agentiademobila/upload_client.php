<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $clientId = $_POST['client_id'];
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $imagePath = 'uploads/' . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            $sql = "UPDATE clienti SET Imagine = ? WHERE Id_client = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $imagePath, $clientId);
            $stmt->execute();
        }
    }
}


$sql = "SELECT * FROM clienti";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Încărcare Document</title>
</head>
<body>
    <h1>Încarcă Document pentru Client</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="client_id">ID Client:</label>
        <input type="number" name="client_id" required>
        <label for="image">Imagine:</label>
        <input type="file" name="image" required>
        <button type="submit">Încarcă</button>
    </form>
</body>
</html>
<?php
$conn->close();
?>
