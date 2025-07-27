<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

$newPassword = $_POST['newPassword'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$matricule = strtoupper(trim($_POST['matricule'] ?? ''));

if ($newPassword === '' || $confirmPassword === '' || $matricule === '') {
    echo json_encode(['success' => false, 'message' => 'Champs manquants']);
    exit;
}

if ($newPassword !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Les mots de passe ne correspondent pas']);
    exit;
}

$hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);

try {
    $sql = "UPDATE agent SET password = :password WHERE Matricul_Agent = :matricule";
    $stmt = $bd->prepare($sql);
    $stmt->execute([
        'password' => $hashPassword,
        'matricule' => $matricule
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Mot de passe mis à jour']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Matricule non trouvé']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
