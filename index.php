<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/app.css">
    <title>Vacin-Saver</title>
</head>
<body>
    <section>
        <div class="Conteneur">
            <div class="conteneur_form">
                <img src="./Asset/Logo-PEV.webp" alt="" id="logo-pev">
                <h1>Login</h1>
                <img src="./Asset/icon.webp" id="guest-male">
                <form action="./traitement/Auth/Login.php" method="POST">
                    <h3 id="matricul">Matricul :</h3>
                    <input type="text" id="matricul" name="matricul" class="matricul_input" required>
                    <h3 id="matricul">Password :</h3>
                    <input type="password" id="password" name="password" class="matricul_input" required>
                    <a href="#" id="Pass">Mot de passe oublie</a>
                    <input type="submit" value="Login" id="btn_login">
                </form>
            </div>
            <div class="ilustration">
                <img src="./Asset/ilustration.webp" alt="">
                <p>
                La vaccination routine est le seul 
                moyen preventif pour  protege 
                nos enfants contre les maladies
                evitables
                </p>
            </div>
        </div>
    </section>
</body>
</html>
