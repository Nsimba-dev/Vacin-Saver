document.getElementById("change_password").addEventListener('click', () => {
    fetch("../src/formulaire_change.php")
        .then(response => response.text())
        .then(data => {
            const conteneur = document.getElementById("conteneur_formulaire");
            conteneur.innerHTML = data;
            console.log(data);
            
            

            const overlay = conteneur.querySelector('#formOverlay');
            if (overlay) {
                overlay.classList.add('active');

                const btnFermer = overlay.querySelector('.fermer-btn');
                if (btnFermer) {
                    btnFermer.addEventListener('click', () => {
                        overlay.classList.remove('active');
                    });
                }

                const form = overlay.querySelector('#matriculeForm'); 
                if (form) {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const formData = new FormData(form);

                        fetch('../traitement/rechercher_agent.php', { // <--- adapter ce chemin
                            method: 'POST',
                            body: formData
                        })
                            .then(resp => resp.json())
                            .then(data => {
                                showNotification(data.success, data.message);
                                if (data.success) {
                                    overlay.classList.remove('active');
                                    form.reset();
                                }
                            })
                            .catch(() => showNotification(false, 'Erreur lors de la requête'));
                    });
                }
            }
        })
        .catch(error => console.error('Erreur de chargement du formulaire :', error));
});

// Fonction pour afficher une notification
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
