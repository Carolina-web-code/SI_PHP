<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agentiedemobila";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interogări Recenzii</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .menu a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
        }
        .menu button {
            width: 100%;
            background-color: #5bc0de;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-align: left;
        }
        .menu button:hover {
            background-color: #46b1d0;
        }
        .output {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Interogări Recenzii</h1>
        <div class="menu">
            <a href="?interogare=1"><button>1. </button></a>
            <a href="?interogare=2"><button>2. </button></a>
            <a href="?interogare=3"><button>3. </button></a>
            <a href="?interogare=4"><button>4. </button></a>

        </div>

        <div class="output">
            <?php
            if (isset($_GET['interogare'])) {
                $interogare = $_GET['interogare'];
                switch ($interogare) {
                    case 1:
                        include('6.php');
                        break;
                    case 2:
                        include('7.php'); 
                        break;
                    case 3:
                        include('8.php'); 
                        break;
                    case 4:
                        include('9.php'); 
                        break;
                        default:
                        echo "Interogare invalidă!";
                }
            } 
            else {
                echo "Selectați o interogare din meniu.";
            }
            ?>
        </div>
    </div>
</body>
</html>
