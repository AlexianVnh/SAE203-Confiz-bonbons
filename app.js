// Tri avec les catégories
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

            // Montrer ou cacher les produits en fonction de l'ID de catégorie
            produits.forEach(produit => {
                if (categoryId === 'all') {
                    produit.style.display = 'flex';
                } else if (produit.getAttribute('data-id') === categoryId) {
                    produit.style.display = 'flex';
                } else {
                    produit.style.display = 'none'; 
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


// Panier
document.addEventListener('DOMContentLoaded', function() {
    const panier = document.getElementById('panier');
    const panierToggle = document.getElementById('panier-toggle');
    const panierCross = document.querySelector('.panier-cross');
    const articlesPanier = document.querySelector('.articles-panier');
    const totalPanier = document.querySelector('.total-panier');

    // Toggle sur l'icône de panier
    panierToggle.addEventListener('click', function(e) {
        e.preventDefault();
        panier.classList.toggle('open');
    });
    // Remove sur l'icône de la croix
    panierCross.addEventListener('click', function(e) {
        e.preventDefault();
        panier.classList.remove('open');
    });

    // Écouter les clics sur les boutons "Retirer" dans le panier
    articlesPanier.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-from-cart')) {
            const itemToRemove = e.target.closest('.panier-item');
            articlesPanier.removeChild(itemToRemove);

            // Mettre à jour le localStorage après la suppression
            savePanier();
            // Mettre à jour le total du panier après suppression d'un article
            mettreAJourTotalPanier();
        }
    });

    // Charger le panier depuis le localStorage
    loadPanier();

    const addToCartForms = document.querySelectorAll('.add-to-cart-form');

    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const produitId = form.querySelector('input[name="produit_id"]').value;
            const produitNom = form.dataset.nom;
            const produitPrix = form.dataset.prix;

            if (produitId && produitNom && produitPrix) {
                const panierItem = createPanierItem(produitNom, produitPrix);
                articlesPanier.appendChild(panierItem);

                // Mettre à jour le localStorage après l'ajout
                savePanier();

                // Mettre à jour le total du panier après l'ajout d'un article
                mettreAJourTotalPanier();
            } else {
                console.error('Données du produit incomplètes');
            }
        });
    });

    function createPanierItem(nom, prix) {
        const panierItem = document.createElement('div');
        panierItem.classList.add('panier-item');
        panierItem.innerHTML = `
            <p>${nom}</p>
            <p>${prix} €</p>
            <button class="remove-from-cart">Retirer</button>
        `;
        return panierItem;
    }

    function savePanier() {
        // Récupérer tous les items du panier actuel
        const itemsPanier = articlesPanier.querySelectorAll('.panier-item');
        
        // Convertir en tableau d'objets simples pour le stockage dans le localStorage
        const panierArray = [];
        itemsPanier.forEach(item => {
            const nom = item.querySelector('p:nth-child(1)').textContent;
            const prix = item.querySelector('p:nth-child(2)').textContent.replace(' €', '');
            panierArray.push({ nom, prix });
        });

        // Stocker dans le localStorage
        localStorage.setItem('panier', JSON.stringify(panierArray));
    }

    function loadPanier() {
        const panierData = JSON.parse(localStorage.getItem('panier'));
        if (panierData) {
            panierData.forEach(item => {
                const panierItem = createPanierItem(item.nom, item.prix);
                articlesPanier.appendChild(panierItem);
            });

            // Mettre à jour le total du panier après chargement depuis localStorage
            mettreAJourTotalPanier();
        }
    }

    // Fonction pour calculer le total du panier
    function calculerTotalPanier() {
        const panierItems = articlesPanier.querySelectorAll('.panier-item');
        let total = 0;

        panierItems.forEach(item => {
            const prixText = item.querySelector('p:nth-child(2)').textContent.trim();
            const prix = parseFloat(prixText.replace(' €', ''));
            total += prix;
        });

        return total.toFixed(2); // Pour arrondir à deux décimales
    }

    // Fonction pour mettre à jour l'affichage du total du panier
    function mettreAJourTotalPanier() {
        const total = calculerTotalPanier();
        totalPanier.textContent = `Total : ${total} €`;
    }
});