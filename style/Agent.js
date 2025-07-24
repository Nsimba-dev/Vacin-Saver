document.getElementById("New_Agent").addEventListener('click', () => {
    fetch("../src/formulaire.php")
        .then(response => response.text())
        .then(data => {
            const conteneur = document.getElementById("conteneur_formulaire");
            conteneur.innerHTML = data;

            const overlay = conteneur.querySelector('#formOverlay');
            if (overlay) {
                overlay.classList.add('active');

                const btnFermer = overlay.querySelector('.fermer-btn');
                if (btnFermer) {
                    btnFermer.addEventListener('click', () => {
                        overlay.classList.remove('active');
                    });
                }

                const form = overlay.querySelector('#agentForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(form);

                        fetch('../traitement/traitement_agent.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(resp => resp.json())
                        .then(data => {
                            showNotification(data.success, data.message, data.matricul, data.password);
                            if (data.success) {
                                overlay.classList.remove('active');
                                form.reset();
                            }
                        })
                        .catch(() => showNotification(false, 'Erreur lors de la requête '));
                    });
                }
            }
        })
        .catch(error => console.error('Erreur de chargement du formulaire :', error));
});

function showNotification(success, message, matricul ="", password ="") {
    const existing = document.getElementById('notificationBox');
    if (existing) existing.remove();

    const notif = document.createElement('div');
    notif.id = 'notificationBox';
    notif.style.position = 'fixed';
    notif.style.top = '20px';
    notif.style.right = '20px';
    notif.style.padding = '30px 25px';
    notif.style.backgroundColor = success ? '#22c55e' : '#ef4444';
    notif.style.color = 'white';
    notif.style.fontWeight = '600';
    notif.style.borderRadius = '6px';
    notif.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
    notif.style.zIndex = 10000;
    notif.style.maxWidth = '600px';
    notif.style.whiteSpace = 'normal';

    let text = matricul;
    if (matricul) text += `<br>Matricul : ${matricul}`;
    if (password) text += `<br>Mot de passe : ${password}`;

    notif.innerHTML = text;

    document.body.appendChild(notif);

    setTimeout(() => {
        notif.style.transition = 'opacity 0.5s ease';
        notif.style.opacity = '0';
        setTimeout(() => notif.remove(), 20000);
    }, 20000);
}

