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
    <title>Interogări Mobilă</title>
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
        <h1>Interogări Mobilă</h1>
        <div class="menu">
            <a href="?interogare=1"><button>1. Selectare mobilă după ID</button></a>
            <a href="?interogare=2"><button>2. Selectare mobilă cu material specific</button></a>
            <a href="?interogare=3"><button>3. Selectare mobilă cu culoare specifică</button></a>
            <a href="?interogare=4"><button>4. Reducere preț cu 10%</button></a>
            <a href="?interogare=5"><button>5. Mobilă mai scumpă decât 2000 lei</button></a>
            <!-- <a href="?interogare=6"><button>6. Găsește toate rândurile din tabelul mobila unde e materialul Compozit</button></a>
            <a href="?interogare=7"><button>7. </button></a>
            <a href="?interogare=8"><button>8. </button></a>
            <a href="?interogare=9"><button>9. </button></a>
            <a href="?interogare=10"><button>10. </button></a> -->
        </div>

        <div class="output">
            <?php
            if (isset($_GET['interogare'])) {
                $interogare = $_GET['interogare'];
                switch ($interogare) {
                    case 1:
                        include('10.php'); 
                        break;
                    case 2:
                        include('12.php');
                        break;
                    case 3:
                        include('13.php'); 
                        break;
                    case 4:
                        include('14.php'); 
                        break;
                    case 5:
                        include('15.php'); 
                        break;
                      /*  case 6:
                            include('16.php'); 
                            break;
                        case 7:
                            include('17.php'); 
                            break;
                        case 8:
                            include('18.php'); 
                            break;
                        case 9:
                            include('19.php'); 
                            break;
                        case 10:
                            include('20.php'); 
                            break; */
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
