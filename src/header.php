<?php
// Protection accès direct au fichier
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header('Location: ../404.php');
    exit;
}

// Vérifie si la session 'admin' est active
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php'); // Redirige vers la page de login
    exit;
}

// Récupère le nom de l'utilisateur connecté
$nom = $_SESSION['admin']['Nom_Admin'] ?? 'Utilisateur';

// Récupère la page actuelle
$pages = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/header.css">
</head>
<body>
<section>
    <!-- En-tête -->
    <header>
        <img src="../Asset/Logo-PEV.webp" alt="Logo">
        <div class="Conteneur_link">
            <nav>
                <div class="other">
                    <div class="link"><a href="../Pages/index.php" class="<?= ($pages == 'index.php') ? 'Active' : ''; ?>"><img src="../Asset/Accueil.png" alt="">Accueil</a></div>
                    <div class="link"><a href="../Pages/Agent.php" class="<?= ($pages == 'Agent.php') ? 'Active' : ''; ?>"><img src="../Asset/agnt.png" alt="">Agent</a></div>
                    <div class="link"><a href="../Pages/Planning.php" class="<?= ($pages == 'Planning.php') ? 'Active' : ''; ?>"><img src="../Asset/planning.png" alt="">Planning</a></div>
                    <div class="link"><a href="../Pages/Statistique.php" class="<?= ($pages == 'Statistique.php') ? 'Active' : ''; ?>"><img src="../Asset/statistics.png" alt="">Statistique</a></div>
                    <div class="link"><a href="../Pages/Chat.php" class="<?= ($pages == 'Chat.php') ? 'Active' : ''; ?>"><img src="../Asset/chat.png" alt="">Chat</a></div>
                </div>
                <div class="Dec">
                    <div class="link"><a href="../traitement/deconnexion.php"><img src="../Asset/dcon.png" alt="">Déconnexion</a></div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Tableau de bord -->
    <div class="Conteneur_init">
        <div class="Conteneur_Dashboard">
            <div class="Ligne"></div>
            <div class="Text">
                <h2>Dashboard</h2>
                <p>
                    Bienvenue, <?= htmlspecialchars($nom) ?>. Nous sommes ravis de vous voir. <br>
                    Voici votre tableau de bord personnalisé pour une gestion efficace et rapide.
                </p>
            </div>
        </div>
        <div class="Conteneur_app">
</body>
</html>
