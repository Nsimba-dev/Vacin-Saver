<?php

session_start();
if (!isset($_SESSION['admin'])) {
    // L'utilisateur n'est pas connecté
    header('Location: ../index.php'); 
    exit;
}

    require_once '../traitement/Auth/config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/Agent.css">
    <link rel="stylesheet" href="../style/planning.css">
    <title>Planning</title>
</head>
<body>
    <?php include '../src/header.php' ;?>
    <!-- App -->
        <div class="Conteneur_app">
            <div class="Conteneur_btn">
                <button id="evenement_click">Crée un evenement</button>
                <button>Suprimme / Modifier Un evenement</button>
            </div>
            <div class="Text">
                <p>Voir un evenement recent :</p>
            </div>
            <div class="Conteneur_list">
                <!-- Requette pour affiche tous le agent en ligne de ma commune d'affectation -->
                <?php
                    $Requette_sql = "SELECT * FROM evenement WHERE Matricul_admin = :Matricul_admin";
                    $matricul = $_SESSION['admin']['Matricul_admin'];
                    try{
                        $Resultat = $bd->prepare($Requette_sql);
                        $Resultat->bindParam(':Matricul_admin', $matricul);
                        $Resultat->execute();
                        $Resultats = $Resultat->fetchAll();
                        if($Resultats){
                            foreach ($Resultats as $row){
                                echo '
                                    <div class="Conteneur_agent">
                                        <div class="identite plannig">
                                            <h2>Titre : '. $row['Titre_evenement'] .'</h2> <br>
                                            <h5>Description : '.$row['Description_evenement'] .'</h5> <br>
                                            <h6>Date de l\'evenement : '.$row['Date_evenement'] .'</h6> <br>
                              
                                            <p>Code de l\'evenement : '.$row['Code_Evenement'].'</p>
                                        </div>
                                    </div>
                                ';
                            }
                        }
                        else{
                                echo '
                                    <div class="Conteneur_agent">
                                        <div class="identite">
                                            <h4>Aucune information trouve</h4>
                                        </div>
                                    </div>
                                ';
                        }
                    }
                    catch(PDOExecption $e){
                        echo "Erreur lors de l'execution de la requette: ". $e->getMessage();
                    }
                ?>  
                              <!-- <p>statue : '.($Resultats['statut'] != "new").'Evenement modifie </p> -->
            </div>
        </div>
    </div>
</section>
    <!-- Formulaire evenement -->
      <style>
    :root {
      --primary-color: #2563eb;
      --secondary-color: #1e40af;
      --text-color: #333;
      --light-bg: #f8fafc;
      --border-color: #e2e8f0;
      --error-color: #dc2626;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }


    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      opacity: 1;
      visibility: visible;
      transition: opacity 1s ease, visibility 0.3s ease;
    }
    .active_me{
        display: flex;
    }
    .container {
      max-width: 600px;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .fermer-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      background: none;
      border: none;
      font-size: 28px;
      color: var(--error-color);
      cursor: pointer;
      z-index: 10001;
    }

    h1 {
      text-align: center;
      color: var(--primary-color);
      margin-bottom: 25px;
      font-size: 28px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--secondary-color);
    }

    input[type="text"], textarea,input[type="date"],
    select {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 16px;
      transition: border 0.3s ease;
    }

    textarea{
        resize: none;
        overflow-y: auto;
    }


    .gender-option input {
      margin-right: 8px;
    }

    button[type="submit"] {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 500;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: var(--secondary-color);
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
      }

      h1 {
        font-size: 24px;
      }
    }
  </style>
  <div class="overlay" id="formOverlay">
    <div class="container">
      <button class="fermer-btn" onclick="fermerFormulaire()">✖</button>

      <h1>Formulaire de creation d'evenement</h1>
      <form id="agentForm" method="POST" action="../traitement/pages_traitement/evenement.php">
        <div class="form-group">
          <label for="nom">Titre</label>
          <input type="text" id="nom" name="Titre" placeholder="Entrez le Titre" required />
        </div>

        <div class="form-group">
          <label for="postnom">Date de l'evenement</label>
          <input type="date" name="date" id=""  required>
        </div>

        <div class="form-group">
          <label for="postnom">Description</label>
          <textarea name="Description" id="" cols="80" rows="10"></textarea>
        </div>

        <button type="submit">Enregistrer</button>
      </form>
    </div>
  </div>

</body>
</html>

<script src="../style/js/evenement.js"></script>
</body>
</html>