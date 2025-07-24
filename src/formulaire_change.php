<!-- Overlay sombre + Formulaire en avant-plan -->
<div id="formOverlay" style="position: fixed; inset: 0; background-color: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 50;">
  <div style="position: relative; width: 100%; max-width: 400px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); padding: 24px;">

    <!-- Bouton Fermer -->
    <button class="fermer-btn" style="position: absolute; top: 8px; right: 8px; color: #f87171; background: none; border: none; font-weight: 600; font-size: 18px; cursor: pointer;">
      ✕
    </button>

    <!-- Formulaire recherche matricule -->
    <form id="matriculeForm" method="POST">
      <div style="margin-bottom: 16px;">
        <label for="matricule" style="display: block; color: #374151; font-weight: 600; margin-bottom: 8px;">Matricule de l'Agent</label>
        <input type="text" id="matricule" name="matricule" placeholder="Ex: AGT-12345" required
          style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
        <p style="color: #6b7280; font-size: 12px; margin-top: 4px;">Saisissez le matricule exact de l'agent</p>
      </div>
      <div style="text-align: right;">
        <button type="submit" style="padding: 8px 16px; background-color: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer;">
          Rechercher
        </button>
      </div>
    </form>

    <!-- Message de chargement -->
    <div id="loadingMessage" style="display: none; text-align: center; padding: 16px 0;">
      <div style="margin: 0 auto; border: 4px solid #2563eb; border-top: 4px solid transparent; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite;"></div>
      <p style="color: #374151; margin-top: 12px;">Vérification du matricule en cours...</p>
    </div>

    <!-- Message d'erreur -->
    <div id="errorMessage" style="display: none; background-color: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 12px; margin-bottom: 16px;">
      <p id="errorText"></p>
    </div>

    <!-- Formulaire de changement de mot de passe -->
    <form id="passwordForm" style="display: none;">
      <input type="hidden" name="matricule" id="hiddenMatricule" />
      <div style="margin-bottom: 24px; text-align: center;">
        <img src="https://placehold.co/150" alt="Portrait de l'agent" style="border-radius: 50%; height: 96px; width: 96px; object-fit: cover; border: 4px solid #bfdbfe; margin-bottom: 12px;" />
        <h2 id="agentName" style="font-size: 20px; font-weight: 600; color: #1e40af;">Agent Trouvé</h2>
        <p id="agentMatriculeDisplay" style="color: #4b5563;"></p>
      </div>

      <div style="display: grid; gap: 16px;">
        <div>
          <label for="newPassword" style="display: block; color: #374151; font-weight: 600; margin-bottom: 8px;">Nouveau mot de passe</label>
          <input type="password" id="newPassword" name="newPassword" required
            style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
        </div>

        <div>
          <label for="confirmPassword" style="display: block; color: #374151; font-weight: 600; margin-bottom: 8px;">Confirmer le nouveau mot de passe</label>
          <input type="password" id="confirmPassword" name="confirmPassword" required
            style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 24px;">
          <button type="button" id="returnBtn" style="padding: 8px 16px; background-color: #6b7280; color: white; border: none; border-radius: 6px; cursor: pointer;">
            Retour
          </button>
          <button type="submit" style="padding: 8px 16px; background-color: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer;">
            Changer le mot de passe
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const matriculeForm = document.getElementById('matriculeForm');
    const passwordForm = document.getElementById('passwordForm');
    const loadingMessage = document.getElementById('loadingMessage');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    const returnBtn = document.getElementById('returnBtn');
    const agentName = document.getElementById('agentName');
    const agentMatriculeDisplay = document.getElementById('agentMatriculeDisplay');
    const hiddenMatricule = document.getElementById('hiddenMatricule');

    matriculeForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const matricule = document.getElementById('matricule').value.trim().toUpperCase();

      // Masquer form et erreur, afficher chargement
      matriculeForm.style.display = 'none';
      errorMessage.style.display = 'none';
      loadingMessage.style.display = 'block';

      fetch('../traitement/rechercher_agent.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ matricule })
      })
      .then(resp => resp.json())
      .then(data => {
        loadingMessage.style.display = 'none';
        if (data.success) {
          agentName.textContent = `${data.agent.Nom_Agent} ${data.agent.Prenom_Agent}`;
          agentMatriculeDisplay.textContent = `Matricule : ${data.matricule}`;
          hiddenMatricule.value = data.matricule;
          passwordForm.style.display = 'block';
        } else {
          errorText.textContent = data.message;
          errorMessage.style.display = 'block';
          matriculeForm.style.display = 'block';
        }
      })
      .catch(() => {
        loadingMessage.style.display = 'none';
        errorText.textContent = 'Erreur lors de la requête';
        errorMessage.style.display = 'block';
        matriculeForm.style.display = 'block';
      });
    });

    returnBtn.addEventListener('click', () => {
      passwordForm.style.display = 'none';
      matriculeForm.style.display = 'block';
    });

    passwordForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const newPassword = document.getElementById('newPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      if (newPassword !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas.');
        return;
      }

      const formData = new FormData(passwordForm);

      fetch('../traitement/traitement_password.php', {
        method: 'POST',
        body: formData
      })
      .then(resp => resp.json())
      .then(data => {
        showNotification(data.success, data.message);
        if (data.success) {
          passwordForm.reset();
          passwordForm.style.display = 'none';
          matriculeForm.style.display = 'block';
        }
      })
      .catch(() => {
        showNotification(false, 'Erreur lors de la requête');
      });
    });

    // Bouton fermer
    const btnFermer = document.querySelector('.fermer-btn');
    if (btnFermer) {
      btnFermer.addEventListener('click', () => {
        const overlay = document.getElementById('formOverlay');
        if (overlay) overlay.remove();
      });
    }
  });

  function showNotification(success, message) {
    const existing = document.getElementById('notificationBox');
    if (existing) existing.remove();

    const notif = document.createElement('div');
    notif.id = 'notificationBox';
    notif.style.position = 'fixed';
    notif.style.top = '20px';
    notif.style.right = '20px';
    notif.style.padding = '15px 25px';
    notif.style.backgroundColor = success ? '#22c55e' : '#ef4444';
    notif.style.color = 'white';
    notif.style.fontWeight = '600';
    notif.style.borderRadius = '6px';
    notif.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
    notif.style.zIndex = 10000;
    notif.style.maxWidth = '300px';
    notif.style.whiteSpace = 'pre-line';
    notif.textContent = message;

    document.body.appendChild(notif);

    setTimeout(() => {
      notif.style.transition = 'opacity 0.5s ease';
      notif.style.opacity = '0';
      setTimeout(() => notif.remove(), 500);
    }, 4000);
  }
</script>
