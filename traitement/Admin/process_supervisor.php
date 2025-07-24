<?php   
    // importation fichi bd condifiguration
require_once(__DIR__ . '/../Auth/config.php');


    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST['Email']) && isset($_POST['Nom_Admin']) && isset($_POST['Post_nom_admin']) && isset($_POST['Prenom_admin']) && isset($_POST['Commune_affectation']) && isset($_POST['Grade_Fonction_admin'])){

            $Email = htmlspecialchars($_POST['Email']);
            $Nom_Admin = htmlspecialchars($_POST['Nom_Admin']);
            $Post_nom_admin = htmlspecialchars($_POST['Post_nom_admin']);
            $Prenom_admin = htmlspecialchars($_POST['Prenom_admin']);
            $Commune_affectation = htmlspecialchars($_POST['Commune_affectation']);
            $Grade_Fonction_admin = htmlspecialchars($_POST['Grade_Fonction_admin']);

            // creation de matricul admin par defaut :
            function genererMatricule() {
                $prefixe = 'ADM';
                $nombre = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // 0000 à 9999
                return $prefixe . $nombre;
            }

            do {
                $Matricul_admin = genererMatricule();

                $sql_check = "SELECT COUNT(*) FROM admin WHERE Matricul_admin = ?";
                $stmt_check = $bd->prepare($sql_check);
                $stmt_check->execute([$Matricul_admin]);
                $existe = $stmt_check->fetchColumn();
            } while ($existe > 0);

            // Genere un mot de passe !
            function genererMotDePasse($longueur = 8) {
            $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+';
            $motDePasse = '';
            $maxIndex = strlen($caracteres) - 1;

            for ($i = 0; $i < $longueur; $i++) {
                $motDePasse .= $caracteres[random_int(0, $maxIndex)];
            }
        
            return $motDePasse;
}
        
            $motDePasseClair = genererMotDePasse();

            $password = password_hash($motDePasseClair, PASSWORD_DEFAULT);

            $statut = "new";
            // Creation d'un nouveau supervisor

            $sqlAnnee = "SELECT id_Annee_vacinnation FROM annee_vacinnation ORDER BY id_Annee_vacinnation DESC LIMIT 1";
            $stmtAnnee = $bd->prepare($sqlAnnee);
            $stmtAnnee->execute();
            $resultAnnee = $stmtAnnee->fetch(PDO::FETCH_ASSOC);

            if ($resultAnnee) {
                $id_Annee_vacinnation = $resultAnnee['id_Annee_vacinnation'];
            } else {
                die("Aucune année trouvée dans la base de données.");
            }

            $sql = 'INSERT INTO admin (	Matricul_admin, Email, password, Nom_Admin, Post_nom_admin, Prenom_admin, Commune_affectation, Grade_Fonction_admin,statut, id_Annee_vacinnation) VALUES
             (:Matricul_admin, :Email, :password, :Nom_Admin, :Post_nom_admin, :Prenom_admin, :Commune_affectation, :Grade_Fonction_admin,:statut, :id_Annee_vacinnation)';

            $rqt = $bd->prepare($sql);
            $rqt->execute([
                ':Matricul_admin' => $Matricul_admin,
                ':Email'  => $Email,
                ':password' => $password,
                ':Nom_Admin' => $Nom_Admin,
                ':Post_nom_admin'=> $Post_nom_admin,
                ':Prenom_admin'=> $Prenom_admin,
                ':Commune_affectation'=> $Commune_affectation,
                ':Grade_Fonction_admin'=> $Grade_Fonction_admin,
                ':statut' => $statut,
                ':id_Annee_vacinnation'=> $id_Annee_vacinnation
            ]);
          echo '
            <form id="redirectForm" action="../../admin/configuration.php" method="POST">
                <input type="hidden" name="message" value="Admin créé avec succès">
                <input type="hidden" name="matricule" value="' . htmlspecialchars($Matricul_admin) . '">
                <input type="hidden" name="password" value="' . htmlspecialchars($motDePasseClair) . '">
            </form>
            <script>
                document.getElementById("redirectForm").submit();
            </script>';
            exit;


    }else {
            echo "Login does not exist.";
        }

    }



?>