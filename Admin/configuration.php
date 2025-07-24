<?php
session_start();

// Vérifier que l'admin est connecté
if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}

$admin = $_SESSION['admin'];
$current_date = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <?php include '../notif/notification.php'; ?>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
        }
        .logout-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s, transform 0.3s;
        }
        .logout-btn:hover {
            background-color: #c0392b;
            transform: translateY(-1px);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-section {
            margin-bottom: 20px;
            display: none;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #fafafa;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-section.active {
            display: block;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s, transform 0.3s;
            margin-right: 10px;
        }
        button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }
        input[type="text"], input[type="date"], input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="text"]:focus, input[type="date"]:focus, input[type="email"]:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
            outline: none;
        }
        .form-title {
            margin-bottom: 10px;
            font-weight: bold;
            color: #4CAF50;
        }
        .info {
            margin: 10px 0;
            font-size: 1rem;
            color: #555;
        }
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logout-container">
            <form action="../traitement/deconnexion.php" method="POST">
                <button type="submit" class="logout-btn">Se déconnecter</button>
            </form>
        </div>

        <h1>Tableau de Bord</h1>
        <p class="info">Agent connecté : <?= htmlspecialchars($admin['Nom_Admin'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p class="info">Date actuelle : <?= $current_date; ?></p>

        <div class="button-container">
            <button id="createVaccinationYearBtn">Créer une Année de Vaccination</button>
            <button id="createSupervisorBtn">Créer un Superviseur</button>
            <button id="createDepartmentBtn">Créer un Département</button>
        </div>

        <div id="vaccinationYearForm" class="form-section">
            <h2 class="form-title">Créer une Année de Vaccination</h2>
            <form action="../traitement/Admin/process_vaccination.php" method="POST">
                <input type="text" name="id_Annee_vacinnation" placeholder="ID Année Vaccination" required>
                <input type="text" name="Annee" placeholder="Année" required>
                <input type="text" name="Periode" placeholder="Période" required>
                <input type="date" name="Debut_vacination" required>
                <input type="date" name="Fin_vacination" required>
                <input type="text" name="Matricul_admin" value="<?= htmlspecialchars($admin['Matricul_admin'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                <button type="submit">Créer Année de Vaccination</button>
            </form>
        </div>

        <div id="supervisorForm" class="form-section">
            <h2 class="form-title">Créer un Superviseur</h2>
            <form action="../traitement/Admin/process_supervisor.php" method="POST">
                <input type="email" name="Email" placeholder="Email" required>
                <input type="text" name="Nom_Admin" placeholder="Nom Admin" required>
                <input type="text" name="Post_nom_admin" placeholder="Post Nom Admin" required>
                <input type="text" name="Prenom_admin" placeholder="Prénom Admin" required>
                <input type="text" name="Commune_affectation" placeholder="Commune d'Affectation" required>
                <input type="text" name="Grade_Fonction_admin" placeholder="Grade/Fonction Admin" required>
                <button type="submit">Créer Superviseur</button>
            </form>
        </div>

        <div id="departmentForm" class="form-section">
            <h2 class="form-title">Créer un Département</h2>
            <form action="../traitement/Admin/process_department.php" method="POST">
                <input type="text" name="Nom_departement" placeholder="Nom du departement" required>
                <input type="text" name="Role" placeholder="Role" required>
                <input type="text" name="Commune_affectation" placeholder="Commune d'Affectation" required>
                <button type="submit">Créer Département</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('createVaccinationYearBtn').addEventListener('click', function() {
            document.getElementById('vaccinationYearForm').classList.toggle('active');
            document.getElementById('supervisorForm').classList.remove('active');
            document.getElementById('departmentForm').classList.remove('active');
        });

        document.getElementById('createSupervisorBtn').addEventListener('click', function() {
            document.getElementById('supervisorForm').classList.toggle('active');
            document.getElementById('vaccinationYearForm').classList.remove('active');
            document.getElementById('departmentForm').classList.remove('active');
        });

        document.getElementById('createDepartmentBtn').addEventListener('click', function() {
            document.getElementById('departmentForm').classList.toggle('active');
            document.getElementById('vaccinationYearForm').classList.remove('active');
            document.getElementById('supervisorForm').classList.remove('active');
        });
    </script>
</body>
</html>
