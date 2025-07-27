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
    <title>Agent</title>
    <script src="https://cdn.tailwindcss.com"></script>
<style>
  .form-container {
    max-width: 500px;
    margin: 2rem auto;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    background-color: white;
  }
  .hidden {
    display: none;
  }
  .animate-spin {
    animation: spin 1s linear infinite;
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

</head>
<body>
    <?php include '../src/header.php' ;?>
    <!-- App -->
        <div class="Conteneur_app">
            <div class="Conteneur_btn">
                <button id="New_Agent">créé un compte agent</button>
                <button id="change_password">change password Agent</button>
                <button>deconnecter un agent</button>
                <button>suprimer un agent</button>
            </div>
            <div class="Text">
                <p>Liste agent Actif : <span></span></p>
            </div>
            <!-- List Agent -->
             <div class="Conteneur_list">
                <!-- Requette pour affiche tous le agent en ligne de ma commune d'affectation -->
                <?php
                    $Requette_sql = "SELECT A.Matricul_Agent , A.Nom_Agent , A.Prenom_Agent , A.statut  FROM agent A INNER JOIN Departement D ON A.id_Departement = D.id_Departement WHERE D.Commune_affectation = :Comunne AND A.statut LIKE'%on%'";
                    try{
                        $Resultat = $bd->prepare($Requette_sql);
                        $Resultat->bindParam(':Comunne', $Commune_affectation);
                        $Resultat->execute();
                        $Resultats = $Resultat->fetchAll();
                        if($Resultats){
                            foreach ($Resultats as $row){
                                echo '
                                      <div class="Conteneur_agent">
                                        <img src="../Asset/Font.webp" alt="">
                                        <div class="identite"><h4>'. $row['Nom_Agent'].' '.$row['Prenom_Agent'].' '.$row['Matricul_Agent'].' </h4></div>
                                    </div>
                                ';
                            }
                        }
                        else{
                            //  echo "<h1>0 Agent en Ligne !</h1>";
                        }
                    }
                    catch(PDOExecption $e){
                        echo "Erreur lors de l'execution de la requette: ". $e->getMessage();
                    }
                ?>  
             </div>
             <!-- Form new agent-->
            <div id="conteneur_formulaire"></div>
        </div>
    </div>
</section>
<script src="../style/js/change_password.js"></script>
<script src="../style/js/confirm_password.js"></script>
<script src="../style/Agent.js"></script>
</body>
</html>
