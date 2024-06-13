/* sélectionner la catégorie */
document.addEventListener('DOMContentLoaded', function () {
    const categorieButtons = document.querySelectorAll('.categorie-button');
    const produitsContainer = document.querySelector('.produits-container');

    categorieButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Retirer la classe 'categorie-button-active' de tous les boutons
            categorieButtons.forEach(btn => btn.classList.remove('categorie-button-active'));
            this.classList.add('categorie-button-active');
        
            const categoryId = this.getAttribute('data-id');
            const produits = document.querySelectorAll('.produit');
            let produitsAffiches = 0; // Initialiser le compteur de produits affichés

            // Montrer ou cacher les produits en fonction de l'ID de catégorie
            produits.forEach(produit => {
                if (categoryId === 'all') {
                    produit.style.display = 'flex'; // Montrer tous les produits
                    produitsAffiches++; // Incrémenter le compteur de produits affichés
                } else if (produit.getAttribute('data-id') === categoryId) {
                    produit.style.display = 'flex'; // Montrer les produits correspondants
                    produitsAffiches++; // Incrémenter le compteur de produits affichés
                } else {
                    produit.style.display = 'none'; // Cacher les produits non correspondants
                }
            });

            // Supprimer le message d'erreur s'il existe déjà
            const erreurMessage = produitsContainer.querySelector('.erreur-message');
            if (erreurMessage) erreurMessage.remove();

            // Si aucun produit n'est affiché, afficher un message d'erreur
            if (produitsAffiches === 0) {
                const erreurMessage = document.createElement('p');
                erreurMessage.textContent = 'Aucun produit trouvé.';
                erreurMessage.classList.add('erreur-message'); // Ajouter une classe pour le cibler facilement
                produitsContainer.appendChild(erreurMessage);
            }
        });
    });
});

