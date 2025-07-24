<?php

require_once 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['matricul']) && isset($_POST['password'])) {
        $login = htmlspecialchars($_POST['matricul']);
        $password = $_POST['password'];

        
        // Préparer et exécuter la requête pour récupérer l'admin
        $requette = $bd->prepare('SELECT * FROM admin WHERE Matricul_admin = :login');
        $requette->bindParam(':login', $login);
        $requette->execute();

        $admin = $requette->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            // Vérifie le mot de passe avec password_verify
            if (password_verify($password, $admin['password'])) {
                // Connexion réussie
                $_SESSION['admin'] = $admin;
                $_SESSION['nom']  = $admin['Nom_Admin'];

                if ($admin['statut'] == "new"){
                    header('Location: ../../confirm_password/');
                }
                else{
                    header('Location: ../../Pages/');
                }
                exit;
            } else {
                header('Location: ../../index.php');
            }
        } else {
             header('Location: ../../index.php');
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    header('Location: ../../404.php');
}