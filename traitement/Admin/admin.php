<?php
require '../Auth/config.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = trim($_POST['matricule'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $bd->prepare("SELECT * FROM Admin_sup WHERE Matricul_admin = :matricule LIMIT 1");
    $stmt->execute(['matricule' => $matricule]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        echo "Matricule incorrect.";
        exit;
    }

    if (password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = [
            'Matricul_admin' => $admin['Matricul_admin'],
            'Nom_Admin' => $admin['Nom_Admin'],
            'Email' => $admin['Email']
        ];
       header("Location: ../../Admin/configuration.php");
        exit();
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Requête non autorisée.";
}
