<?php 

    session_start();
    $matricul = $_SESSION['admin']['Matricul_admin'];

    // importation fichi bd condifiguration
require_once(__DIR__ . '/../Auth/config.php');


    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST['password']) && isset($_POST['confirm_password'])){
            $mdp = htmlspecialchars($_POST['password']);
            $confirm_password = htmlspecialchars($_POST['confirm_password']);
            if ($mdp != $confirm_password){
                header("Location: ../../confirm_password/index.php");
            }
            else{
                $password = password_hash($mdp, PASSWORD_DEFAULT);
                $statut = "valider";
                // rqt

                $rqt = "UPDATE admin SET password =:password , statut=:statut WHERE Matricul_admin =:Matricul";
                $smtp = $bd->prepare($rqt);
                $smtp->bindParam(':password',$password);
                $smtp->bindParam(':statut',$statut);
                $smtp->bindParam(':Matricul',$matricul);
                $smtp->execute();

                header('Location: ../../Pages/');


            }
    }else {
            echo "Login does not exist.";
        }

    }