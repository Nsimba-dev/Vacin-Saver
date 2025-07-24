<?php 

session_start();

if (!isset($_SESSION['admin'])) {
    // L'utilisateur n'est pas connecté
    header('Location: ../index.php'); 
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/confirm_password.css">
    <title>Confirmation du mot de passe</title>
</head>
<body>
    <div class="Conteneur_form">
        <div class="conteneur_img"><img src="../Asset/Logo-PEV.webp" alt=""></div>
        <form action="../traitement/Admin/confirm_password.php" method="post">
            <h2>Veuillez Crée un nouveau mot de passe !</h2>
            <label for="">Bienvenue ! Mr : <?=     $nom = $_SESSION['nom']; htmlspecialchars($nom) ?></label>
            <label for="">Crée un nouveau mot de passe : </label>
            <input type="password" name="password" id="password" required>
            <label for="">Confirme mot de passe :</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <input type="submit" value="Confirme">
        </form>
    </div>
</body>
<script src="../style/js/confirm_password.js"></script>
</html>