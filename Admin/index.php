<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
        }

        .login-container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-group label {
            position: absolute;
            left: 15px;
            top: 15px;
            color: #999;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            top: -8px;
            left: 10px;
            font-size: 0.8rem;
            background-color: white;
            padding: 0 5px;
            color: #4CAF50;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #4CAF50;
            text-decoration: underline;
        }

        .click-effect {
            animation: clickAnimation 0.4s ease-out;
        }

        @keyframes clickAnimation {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(0.98);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Connexion</h1>
        <form id="loginForm" method="post" Action="../traitement/Admin/admin.php">
            <div class="input-group">
                <input type="text" id="username" placeholder=" " required name="matricule">
                <label for="username">Nom d'utilisateur</label>
            </div>
            <div class="input-group">
                <input type="password" id="password" placeholder=" " required name="password">
                <label for="password">Mot de passe</label>
            </div>
            <button type="submit" class="login-btn" id="loginBtn">Se connecter</button>
            <div class="forgot-password">
                <a href="#">Mot de passe oublié ?</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-group input');
            
            inputs.forEach(input => {
                // Animation au focus
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('click-effect');
                    setTimeout(() => {
                        this.parentElement.classList.remove('click-effect');
                    }, 400);
                });
                
                // Empêche l'animation lors du tab
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Tab') {
                        this.parentElement.classList.remove('click-effect');
                    }
                });
            });
            
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const loginBtn = document.getElementById('loginBtn');
                loginBtn.textContent = 'Connexion...';
                loginBtn.disabled = true;
                
            });
        });
    </script>
</body>
</html>

