<?php
session_start();
require_once '../traitement/Auth/config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    body {
      background-color: var(--light-bg);
      color: var(--text-color);
      line-height: 1.6;
      padding: 20px;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;

      opacity: 1;
      visibility: visible;
      transition: opacity 0.3s ease, visibility 0.3s ease;
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

    input[type="text"], input[type="email"],
    select {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 16px;
      transition: border 0.3s ease;
    }

    input[type="text"]:focus, input[type="email"]:focus,  
    select:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .gender-options {
      display: flex;
      gap: 20px;
      margin-top: 10px;
    }

    .gender-option {
      display: flex;
      align-items: center;
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
</head>
<body>
  <div class="overlay" id="formOverlay">
    <div class="container">
      <button class="fermer-btn" onclick="fermerFormulaire()">✖</button>

      <h1>Formulaire d'enregistrement d'agent</h1>
      <form id="agentForm" method="POST" action="../traitement/pages_traitement/traitement_agent.php">
        <div class="form-group">
          <label for="nom">Nom</label>
          <input type="text" id="nom" name="nom" placeholder="Entrez le nom" required />
        </div>

        <div class="form-group">
          <label for="postnom">Postnom</label>
          <input type="text" id="postnom" name="postnom" placeholder="Entrez le postnom" required />
        </div>

        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" placeholder="Entrez le prénom" required />
        </div>

        <div class="form-group">
          <label for="Email">Email</label>
          <input type="email" id="Email" name="Email" placeholder="Entrez l'Email" required />
        </div>       

        <div class="form-group">
          <label for="departement">Département</label>
          <select name="departement" id="departement" required>
            <?php
              $Commune_affectation = $_SESSION['admin']['Commune_affectation'];
              $rqt = "SELECT Nom_departement FROM departement WHERE Commune_affectation = :Commune_affectation ORDER BY Nom_departement";
              $smtp = $bd->prepare($rqt);
              $smtp->bindParam(':Commune_affectation', $Commune_affectation);
              $smtp->execute();
              $departement = $smtp->fetchAll(PDO::FETCH_COLUMN);
              if (!empty($departement)) {
                foreach ($departement as $nom) {
                  echo '<option value="' . htmlspecialchars($nom) . '">' . htmlspecialchars($nom) . '</option>';
                }
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label>Sexe</label>
          <div class="gender-options">
            <div class="gender-option">
              <input type="radio" id="masculin" name="sexe" value="masculin" checked />
              <label for="masculin">Masculin</label>
            </div>
            <div class="gender-option">
              <input type="radio" id="feminin" name="sexe" value="feminin" />
              <label for="feminin">Féminin</label>
            </div>
          </div>
        </div>

        <button type="submit">Enregistrer</button>
      </form>
    </div>
  </div>

  <script>
    function fermerFormulaire() {
      document.getElementById('formOverlay').classList.remove('active');
    }
    fermerFormulaire() 
  </script>
</body>
</html>
