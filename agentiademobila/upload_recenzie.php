<?php
/*$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'agentiedemobila';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["document"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (getimagesize($_FILES["document"]["tmp_name"]) === false) {
        echo "Fișierul nu este o imagine.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Scuze, doar fișierele JPG, JPEG, PNG și GIF sunt permise.";
        $uploadOk = 0;
    }

    if ($_FILES["document"]["size"] > 500000) {
        echo "Fișierul este prea mare.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Fișierul nu a fost încărcat.";
    } else {
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
            echo "Fișierul " . htmlspecialchars(basename($_FILES["document"]["name"])) . " a fost încărcat.";
        } else {
            echo "A apărut o eroare la încărcarea fișierului.";
        }
    }
}


<form action="upload_recenzie.php" method="post" enctype="multipart/form-data">
    Selectați imaginea sau documentul pentru recenzie:
    <input type="file" name="document" id="document">
    <button type="submit">Încarcă</button> 
</form>
*/ ?>