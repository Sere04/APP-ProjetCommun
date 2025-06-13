<?php

require_once(__DIR__ . '/connectToDB.php');

try {
    $pdo = connectToDBALL();
    // Récupération des capteurs
    $stmt = $pdo->query("
        SELECT ca.id_objet, ca.nom, ca.description, ca.unite, t.nom AS type_nom
        FROM capteur_actionneur ca
        JOIN type t ON ca.id_type = t.id_type
        WHERE t.est_actionneur = 0
    ");
    $capteurs = $stmt->fetchAll();

    $result = [];

    foreach ($capteurs as $capteur) {
        $stmtMesure = $pdo->prepare(
            "SELECT valeur_mesure, date_mesure 
             FROM mesures 
             WHERE id_objet = ? 
             ORDER BY date_mesure DESC 
             LIMIT 1"
        );
        $stmtMesure->execute([$capteur['id_objet']]);
        $mesure = $stmtMesure->fetch();

        if (isset($mesure['valeur_mesure'])) {
            $valeur = $mesure['valeur_mesure'];
            if (!empty($capteur['unite'])) {
                $valeur .= ' ' . $capteur['unite'];
            }
        } else {
            $valeur = "Aucune donnée disponible";
        }

        $result[] = [
            'id_objet'      => $capteur['id_objet'],
            'nom'           => $capteur['type_nom'],
            'description'   => $capteur['description'],
            'valeur_mesure' => $valeur,
            'date_mesure'   => $mesure['date_mesure'] ?? "Aucune donnée disponible"
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($result);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

?>