<?php
session_start();

require_once __DIR__ . '/../Models/connectToDB.php';
$pdoPrivee = connectToDB();
$pdoPublique = connectToDBALL();

$id_objet = 4;
$id_type = 4;

if (isset($_POST['reset'])) {
    $pdoPrivee->exec("DELETE FROM Occupation");
    $pdoPublique->prepare("DELETE FROM mesures WHERE id_objet = ?")->execute([$id_objet]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$privates = $pdoPrivee->query("SELECT timestamp, value FROM Occupation ORDER BY id ASC")->fetchAll();
foreach ($privates as $row) {
    $stmt = $pdoPublique->prepare("SELECT COUNT(*) FROM mesures WHERE id_objet = ? AND date_mesure = ?");
    $stmt->execute([$id_objet, $row['timestamp']]);
    if ($stmt->fetchColumn() == 0) {
        $stmtInsert = $pdoPublique->prepare("INSERT INTO mesures (id_objet, date_mesure, valeur_mesure) VALUES (?, ?, ?)");
        $stmtInsert->execute([$id_objet, $row['timestamp'], $row['value']]);
    }
}

$pdo = $pdoPrivee;
$stmt = $pdo->query("SELECT id, timestamp, value FROM Occupation ORDER BY id DESC LIMIT 1");
$last = $stmt->fetch();

$compteur = $last ? intval($last['value']) : 0;
$heure = $last ? date('d/m/Y H:i:s', strtotime($last['timestamp'])) : 'Aucune mesure';

$stmt = $pdo->query("SELECT timestamp, value FROM Occupation ORDER BY id DESC LIMIT 20");
$historique = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Capacité Portique</title>
    <link href="./assets/css/style.css" rel="stylesheet">
    <style>
        body {
        min-height: 100vh;
        margin: 0;
        background-color: #f8f8fa;
        font-family: 'Montserrat', sans-serif;
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 1rem 0;
        overflow: hidden;
    }

   .background-circle {
            position: absolute;
            width: 500px;
            height: 500px;
            top:-60%;
            left: -130%;
            background: radial-gradient(circle, rgba(201, 41, 128, 0.3), rgba(247, 130, 52, 0.3), rgba(172, 30, 163, 0.3));
            border-radius: 50%;
            filter: blur(30px);
            z-index: -1;
}
.background-circle-bas{
    position: fixed;
    bottom: 0;
    top: 70%;
    left: 190%;
    transform: translateX(-50%);
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(201, 41, 128, 0.3), rgba(247, 130, 52, 0.3), rgba(172, 30, 163, 0.3));
    border-radius: 50%;
    filter: blur(30px);
    z-index: 2;
    pointer-events: none;
    overflow: hidden;
}
 .go-to-home-button {
        background:  rgb(247, 130, 52);
        width: 8%;
        border: none;
        margin-left: 4%;
        font-weight: 600;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 0.5rem;
        border-radius:8px;
        color: white;
        z-index: 2;

    }
        .container {
            position: relative;
        z-index: 1;
        width: 90%;
        max-width: 420px;
        padding: 2rem 2.5rem;
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        margin: auto;
        }
        .count {
            font-size: 5em;
            color: #c92980;
            margin: 30px 0 10px 0;
            font-weight: 800;
            letter-spacing: -2px;
            text-align: center;
        }
        .label {
            font-size: 2em;
            margin-bottom: 10px;
            color: #222;
        }
        .heure {
            font-size: 1.1em;
            color: #888;
            margin-bottom: 30px;
        }
        .btn-historique {
            margin: 20px 0 0 0;
            padding: 10px 30px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            background: linear-gradient(90deg, rgb(201,41,128), rgb(247,130,52), rgb(172,30,163));
            color: #fff;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
            margin-left:8%;
        }
        .btn-historique:hover {
            background: linear-gradient(90deg, rgb(172,30,163), rgb(247,130,52), rgb(201,41,128));
        }
        .btn-reset {
            margin-bottom: 25px;
            padding: 12px 36px;
            font-size: 1.2em;
            border: none;
            border-radius: 32px;
            background: linear-gradient(90deg, rgb(201,41,128), rgb(247,130,52), rgb(172,30,163));
            color: #fff;
            cursor: pointer;
            font-weight: 700;
            box-shadow: 0 2px 12px 0 rgba(201,41,128,0.10);
            transition: background 0.2s, transform 0.15s;
            letter-spacing: 1px;
        }
        .btn-reset:hover {
            background: linear-gradient(90deg, rgb(172,30,163), rgb(247,130,52), rgb(201,41,128));
            transform: scale(1.04);
        }
        .historique {
            margin-top: 30px;
            display: none;
            width: 100%;
            max-width: 420px;
        }
        .historique.show {
            display: block;
        }
        .historique-scroll {
            max-height: 320px;
            overflow-y: auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 12px 0 rgba(201,41,128,0.06);
        }
        .historique table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
        }
        .historique th, .historique td {
            padding: 8px 5px;
            border-bottom: 1px solid #eee;
            color: #222;
        }
        .historique th {
            color: #c92980;
            font-weight: 700;
            background: #f8f8fa;
        }
        .show { display: block; }
        .center { text-align: center; }
        .showmore {
            color: #c92980;
            cursor: pointer;
            font-size: 1em;
            margin-top: 10px;
            display: inline-block;
        }
        @media (max-width: 600px) {
            .container { padding: 1.5rem 0.5rem; }
            .count { font-size: 2.5em; }
            .label { font-size: 1.2em; }
        }
    </style>
</head>
<body>
             <button type="button" class="go-to-home-button" onclick="window.location.href = '../Views/home.php';">Accueil</button> 
   
    <div class="container">
         <div class="background-circle"></div>
        <div class="background-circle-bas"></div>
        <form method="post">
            <button type="submit" name="reset" class="btn-reset">Réinitialiser toutes les mesures</button>
        </form>
        <div class="label">Nombre de personnes présentes</div>
        <div class="count" id="compteur"><?= htmlspecialchars($compteur) ?></div>
        <div class="heure" id="heure">Dernière mesure : <?= htmlspecialchars($heure) ?></div>
        <button class="btn-historique" id="btn-historique" onclick="toggleHistorique()">Afficher l'historique de passage</button>
        <div class="historique" id="historique">
            <div class="historique-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Heure</th>
                            <th>Compteur</th>
                        </tr>
                    </thead>
                    <tbody id="hist-body">
                    <?php
                    foreach ($historique as $h) {
                        echo '<tr><td>' . date('d/m/Y H:i:s', strtotime($h['timestamp'])) . '</td><td class="center">' . intval($h['value']) . '</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        let historiqueVisible = false;
        let historique = <?= json_encode($historique) ?>;
        let maxAffiche = 5;

        function toggleHistorique() {
            const hist = document.getElementById('historique');
            const btn = document.getElementById('btn-historique');
            hist.classList.toggle('show');
            if (hist.classList.contains('show')) {
                btn.textContent = "Masquer l'historique de passage";
            } else {
                btn.textContent = "Afficher l'historique de passage";
            }
        }

        function refreshCompteur() {
            fetch('../Models/get_capacite.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('compteur').textContent = data.compteur;
                    document.getElementById('heure').textContent = "Dernière mesure : " + data.heure;
                });
        }

        function refreshHistorique() {
            fetch('../Models/get_historique.php')
                .then(response => response.json())
                .then(historique => {
                    let tbody = document.getElementById('hist-body');
                    tbody.innerHTML = '';
                    historique.forEach(h => {
                        let date = new Date(h.timestamp.replace(' ', 'T'));
                        let dateStr = date.toLocaleDateString('fr-FR') + ' ' + date.toLocaleTimeString('fr-FR');
                        tbody.innerHTML += `<tr><td>${dateStr}</td><td class="center">${parseInt(h.value)}</td></tr>`;
                    });
                });
        }

        setInterval(() => {
            refreshCompteur();
            refreshHistorique();
        }, 2000);

        window.onload = () => {
            refreshCompteur();
            refreshHistorique();
        };
    </script>
</body>
</html>