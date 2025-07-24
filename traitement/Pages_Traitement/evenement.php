<?php   
    // importation fichi bd condifiguration
  require_once(__DIR__ . '/../Auth/config.php');

  session_start();
  $matricul = $_SESSION['admin']['Matricul_admin'];
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['Titre']) && isset($_POST['Description']) && isset($_POST['date'])){
      $titre = htmlspecialchars($_POST['Titre']);
      $Description = htmlspecialchars($_POST['Description']);
      $date = htmlspecialchars($_POST['date']);
      
      // creation de code admin par defaut :
      function genererMatricule() {
          $prefixe = 'EVN';
          $nombre = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // 0000 à 9999
          return $prefixe . $nombre;
      }
      do {
          $code_event = genererMatricule();
          $sql_check = "SELECT COUNT(*) FROM evenement WHERE 	Code_Evenement = ?";
          $stmt_check = $bd->prepare($sql_check);
          $stmt_check->execute([$code_event]);
          $existe = $stmt_check->fetchColumn();
      } while ($existe > 0);
      // statut
      $statut = "new";

      $sql = 'INSERT INTO evenement (Code_Evenement, Description_evenement, Date_evenement, Titre_evenement, statut, Matricul_admin) VALUES
      (:Code_Evenement, :Description_evenement, :Date_evenement, :Titre_evenement, :statut, :Matricul_admin)';

      $rqt = $bd->prepare($sql);
      $rqt->execute([
          ':Code_Evenement' =>  $code_event,
          ':Description_evenement'  => $Description,
          ':Date_evenement' => $date,
          ':Titre_evenement' => $titre,
          ':statut'=> $statut,
          ':Matricul_admin'=> $matricul
      ]);
      header("Location: ../../Pages/Planning.php?success");
    }
  
  }
      




      
      
      
      
      
      
      
      





    

        




?>