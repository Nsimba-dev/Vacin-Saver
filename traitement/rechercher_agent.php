<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './Auth/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

if (empty($_POST['matricule'])) {
    echo json_encode(['success' => false, 'message' => 'Matricule manquant']);
    exit;
}

$matricule = strtoupper(trim($_POST['matricule']));

try {
    $sql = "SELECT Nom_Agent, Prenom_Agent FROM Agent WHERE Matricul_Agent = :matricule LIMIT 1";
    $stmt = $bd->prepare($sql);
    $stmt->execute(['matricule' => $matricule]);
    $agent = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($agent) {
        $agent = $agent["Nom_Agent"];
        echo json_encode(
            ['success' => true, 
            'agent' => $agent, 
            'matricule' => $matricule
            ]
        );
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun agent trouvé']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
