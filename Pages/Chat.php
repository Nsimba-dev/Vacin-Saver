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
    <title>Discussion</title>
</head>
<body>
    <?php include '../src/header.php' ;?>
    <!-- App -->
        <div class="Conteneur_app">
              
        </div>
    </div>
</section>
</body>
</html>