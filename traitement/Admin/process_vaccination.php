<?php   
    // importation fichi bd condifiguration
require_once(__DIR__ . '/../Auth/config.php');


    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST['Annee']) && isset($_POST['Periode']) && isset($_POST['Debut_vacination']) && isset($_POST['Fin_vacination']) && isset($_POST['Matricul_admin'])){

            $anne = htmlspecialchars($_POST['Annee']);
            $Periode = htmlspecialchars($_POST['Periode']);
            $Debut_vacination = htmlspecialchars($_POST['Debut_vacination']);
            $Fin_vacination = htmlspecialchars($_POST['Fin_vacination']);
            $Matricul_admin = htmlspecialchars($_POST['Matricul_admin']);
            
            $sql = 'INSERT INTO annee_vacinnation (Annee, Periode, Debut_vacination, Fin_vacination, Matricul_admin) VALUES (:annee, :periode, :debut, :fin, :matricule)';

            $rqt = $bd->prepare($sql);
            $rqt->execute([
                ':annee'    => $anne,
                ':periode'  => $Periode,
                ':debut'    => $Debut_vacination,
                ':fin'      => $Fin_vacination,
                ':matricule'=> $Matricul_admin
            ]);
            header("Location: ../../Admin/configuration.php?success");


    }else {
            echo "Login does not exist.";
        }

    }



?>