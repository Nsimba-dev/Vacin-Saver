<?php
$matricule = $_POST['matricule'] ?? null;
$password = $_POST['password'] ?? null;
$shouldShow = $matricule && $password;
?>

<?php if ($shouldShow): ?>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    .container {
        max-width: 400px;
        margin: 0 auto;
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        position: relative;
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .hide {
        opacity: 0;
        transform: scale(0.95);
        pointer-events: none;
    }

    .close-button {
        position: absolute;
        top: 10px;
        right: 12px;
        background: transparent;
        border: none;
        font-size: 20px;
        color: #999;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close-button:hover {
        color: #e74c3c;
    }

    h3 {
        color: #2c3e50;
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .credentials-container {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #2c3e50;
    }

    .credential-item {
        margin-bottom: 15px;
        padding: 15px;
        background: white;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .credential-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .credential-value {
        padding: 8px;
        background: #f5f5f5;
        border-radius: 4px;
        font-family: monospace;
    }

    .countdown {
        text-align: center;
        font-size: 14px;
        color: #666;
        margin-top: 10px;
    }
</style>

<div class="container" id="notificationBox">
    <button class="close-button" onclick="closeNotification()">×</button>
    <div class="credentials-container">
        <h3>Accès autorisés</h3>
        <div class="credential-item">
            <div class="credential-title">Matricule</div>
            <div class="credential-value"><?= htmlspecialchars($matricule) ?></div>
        </div>

        <div class="credential-item">
            <div class="credential-title">Mot de passe</div>
            <div class="credential-value"><?= htmlspecialchars($password) ?></div>
        </div>
    </div>
    <div class="countdown" id="countdownTimer">
        Fermeture automatique dans 2:00 minutes
    </div>
</div>

<script>
    const countdownElement = document.getElementById('countdownTimer');
    let timeLeft = 120; // 2 minutes

    const interval = setInterval(() => {
        timeLeft--;

        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        if (seconds < 10) seconds = '0' + seconds;

        countdownElement.textContent = `Fermeture automatique dans ${minutes}:${seconds} minutes`;

        if (timeLeft <= 0) {
            clearInterval(interval);
            closeNotification();
        }
    }, 1000);

    function closeNotification() {
        const box = document.getElementById('notificationBox');
        box.classList.add('hide');
        setTimeout(() => box.remove(), 500);
    }
</script>
<?php endif; ?>
