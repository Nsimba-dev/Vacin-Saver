<?php   
    // importation fichi bd condifiguration
require_once(__DIR__ . '/../Auth/config.php');


    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST['Nom_departement']) && isset($_POST['Role']) && isset($_POST['Commune_affectation'])){

            $Nom_departement = htmlspecialchars($_POST['Nom_departement']);
            $Role = htmlspecialchars($_POST['Role']);
            $Commune_affectation = htmlspecialchars($_POST['Commune_affectation']);


            $sqlAnnee = "SELECT id_Annee_vacinnation FROM annee_vacinnation ORDER BY id_Annee_vacinnation DESC LIMIT 1";
            $stmtAnnee = $bd->prepare($sqlAnnee);
            $stmtAnnee->execute();
            $resultAnnee = $stmtAnnee->fetch(PDO::FETCH_ASSOC);

            if ($resultAnnee) {
                $id_Annee_vacinnation = $resultAnnee['id_Annee_vacinnation'];
            } else {
                die("Aucune année trouvée dans la base de données.");
            }

            $sql = 'INSERT INTO departement (Nom_departement, Role, Commune_affectation, id_Annee_vacinnation) 
            VALUES (:Sensibilise, :Vaccination, :Commune_affectation, :id_Annee_vacinnation)';

            $rqt = $bd->prepare($sql);
            $rqt->execute([
                ':Sensibilise' =>$Nom_departement,
                ':Vaccination'  => $Role,
                ':Commune_affectation'  => $Commune_affectation,
                ':id_Annee_vacinnation' => $id_Annee_vacinnation
            ]);
            header("Location: ../../Admin/configuration.php?success");



    }else {
            echo "Login does not exist.";
        }

    }



?>