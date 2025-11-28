document.addEventListener('DOMContentLoaded', function() {
    const btnsfavoris = document.querySelectorAll('.btn-favoris');
    
    btnsavoris.forEach(btn => {
        btn.addEventListener('click', async function() {
            const lieuId = this.dataset.lieuId;
            const isFavori = this.dataset.isFavori === 'true';
            
            try {
                const response = await fetch(`/favoris/toggle/${lieuId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Mettre à jour l'interface
                    const heartIcon = this.querySelector('.heart-icon');
                    const text = this.querySelector('.favoris-text');
                    
                    if (data.action === 'added') {
                        heartIcon.textContent = '❤️';
                        text.textContent = 'Retirer des favoris';
                        this.dataset.isFavori = 'true';
                    } else {
                        heartIcon.textContent = '🤍';
                        text.textContent = 'Ajouter aux favoris';
                        this.dataset.isFavori = 'false';
                    }
                    
                    // Afficher un message (optionnel)
                    showNotification(data.message);
                }
            } catch (error) {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue', 'error');
            }
        });
    });
});

function showNotification(message, type = 'success') {
    // Votre système de notification
    console.log(message);
}