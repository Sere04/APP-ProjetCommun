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
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f8f8fa;
            position: relative;
            overflow-x: hidden;
            color: #222;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .background-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 600px;
            height: 600px;
            transform: translate(-50%, -55%);
            background: radial-gradient(circle at 60% 40%, rgb(201, 41, 128), rgb(247, 130, 52), rgb(172,30,163));
            border-radius: 50%;
            z-index: 0;
            filter: blur(45px);
            pointer-events: none;
        }
        .global-blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(60px);
            z-index: 0;
            pointer-events: none;
        }
        .container {
            max-width: 500px;
            width: 100%;
            background: #fff;
            border-radius: 32px;
            box-shadow: 0 4px 24px 0 rgba(201,41,128,0.08);
            padding: 40px 30px 30px 30px;
            z-index: 2;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .count {
            font-size: 5em;
            color: #c92980;
            margin: 30px 0 10px 0;
            font-weight: 800;
            letter-spacing: -2px;
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
    <div class="background-circle"></div>
    <div class="global-blur-overlay"></div>
    <div class="container">
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
            fetch('get_capacite.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('compteur').textContent = data.compteur;
                    document.getElementById('heure').textContent = "Dernière mesure : " + data.heure;
                });
        }

        function refreshHistorique() {
            fetch('get_historique.php')
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