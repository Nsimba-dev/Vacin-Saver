<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './Auth/config.php';

header('Content-Type: application/json');

try {
    $nom = $_POST['nom'] ?? '';
    $postnom = $_POST['postnom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['Email'] ?? '';
    $departementNom = $_POST['departement'] ?? '';
    $sexe = $_POST['sexe'] ?? '';

    // Récupération de la commune depuis la session
    $commune = $_SESSION['admin']['Commune_affectation'] ?? '';

    if (!$nom || !$postnom || !$prenom || !$email || !$departementNom || !$commune || !$sexe) {
        throw new Exception("Tous les champs sont requis.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email invalide.");
    }

    // Récupérer id_Departement selon commune ET département
    $stmtDep = $bd->prepare("SELECT id_Departement FROM departement WHERE Nom_departement = :nomDept AND Commune_affectation = :commune LIMIT 1");
    $stmtDep->execute([
        ':nomDept' => $departementNom,
        ':commune' => $commune
    ]);
    $idDepartement = $stmtDep->fetchColumn();

    if (!$idDepartement) {
        throw new Exception("Département ou commune invalide ou non trouvé.");
    }

    $matricul = 'AG' . random_int(1000, 9999);
    $password = bin2hex(random_bytes(4));

    $sql = "INSERT INTO Agent (
        Matricul_Agent, Email, password, Nom_Agent, Post_nom_Agent, Prenom_Agent, Nom_Comune, Sexe_Agent, statut, id_Departement
    ) VALUES (
        :matricul, :email, :password, :nom, :postnom, :prenom, :commune, :sexe, :statut, :id_departement
    )";

    $stmt = $bd->prepare($sql);
    $stmt->execute([
        ':matricul' => $matricul,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT),
        ':nom' => $nom,
        ':postnom' => $postnom,
        ':prenom' => $prenom,
        ':commune' => $commune,
        ':sexe' => $sexe,
        ':statut' => 1,
        ':id_departement' => $idDepartement
    ]);
    echo json_encode([
        'success' => true,
        'message' => 'Agent enregistré avec succès ',
        'matricul' =>$matricul,
        'password' => $password
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur : ' . $e->getMessage()
    ]);
}
