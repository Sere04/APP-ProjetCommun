<?php
require_once(__DIR__ . '/connectToDB.php');

try {
    $pdo = connectToDBALL();
    // Récupère tous les capteurs
    $stmt = $pdo->query("
        SELECT ca.id_objet, ca.nom, ca.description, ca.unite, t.nom AS type_nom
        FROM capteur_actionneur ca
        JOIN type t ON ca.id_type = t.id_type
        WHERE t.est_actionneur = 0
    ");
    $capteurs = $stmt->fetchAll();

    $result = [];

    foreach ($capteurs as $capteur) {
        $stmtMesures = $pdo->prepare(
            "SELECT valeur_mesure, date_mesure 
             FROM mesures 
             WHERE id_objet = ? 
             ORDER BY date_mesure ASC"
        );
        $stmtMesures->execute([$capteur['id_objet']]);
        $mesures = $stmtMesures->fetchAll();

        $mesuresArray = [];
        foreach ($mesures as $mesure) {
            $mesuresArray[] = [
                'valeur' => $mesure['valeur_mesure'],
                'date'   => $mesure['date_mesure']
            ];
        }

        $result[] = [
            'id_objet'      => $capteur['id_objet'],
            'nom'           => $capteur['type_nom'],
            'description'   => $capteur['description'],
            'unite'         => $capteur['unite'],
            'mesures'       => $mesuresArray
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