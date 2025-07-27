<!-- Modal Boutique -->
<div id="boutiqueModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-6xl rounded-lg shadow-xl bg-white">
        <!-- En-tête de la modale -->
        <div class="flex justify-between items-center pb-3 border-b mb-6">
            <h3 class="text-2xl font-bold text-gray-800" id="modalBoutiqueNom">Nom de la boutique</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Contenu de la modale -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Section gauche - Informations de la boutique -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <!-- Logo et nom -->
                        <div class="flex flex-col items-center text-center mb-6">
                            <img id="modalBoutiqueLogo" src="" alt="Logo boutique" class="h-24 w-24 object-contain mb-4">
                            <h4 id="modalBoutiqueNom2" class="text-xl font-bold text-gray-900">Nom de la boutique</h4>
                            <div id="modalBoutiqueNote" class="flex items-center mt-2">
                                <!-- Les étoiles seront ajoutées dynamiquement -->
                            </div>
                            <span id="modalBoutiqueAvis" class="text-sm text-gray-500">(0 avis)</span>
                        </div>

                        <!-- Informations -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <i class="fas fa-tag text-blue-600 w-5 mr-2"></i>
                                <span class="text-gray-700">Catégorie: <span id="modalBoutiqueCategorie" class="font-medium"></span></span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-blue-600 w-5 mr-2"></i>
                                <span class="text-gray-700">Paiement sécurisé</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-truck text-blue-600 w-5 mr-2"></i>
                                <span class="text-gray-700">Livraison: <span id="modalBoutiqueLivraison" class="font-medium"></span></span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-undo-alt text-blue-600 w-5 mr-2"></i>
                                <span class="text-gray-700">Retours sous 30 jours</span>
                            </div>
                        </div>

                        <!-- Cashback -->
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg text-center">
                            <p class="text-sm text-gray-600">Cashback jusqu'à</p>
                            <p id="modalBoutiqueCashback" class="text-2xl font-bold text-blue-700">0%</p>
                            <p class="text-xs text-gray-500 mt-1">Crédité après validation de votre commande</p>
                        </div>

                        <!-- Bouton visiter la boutique -->
                        <a id="modalBoutiqueLien" href="#" target="_blank" class="mt-6 w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300">
                            Visiter la boutique <i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Section droite - Produits de la boutique -->
            <div class="lg:col-span-2">
                <h4 class="text-xl font-bold text-gray-800 mb-6">Produits populaires</h4>
                <div id="produitsBoutique" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Les produits seront chargés ici dynamiquement -->
                    <div class="text-center py-10">
                        <div class="animate-pulse">
                            <div class="h-4 bg-gray-200 rounded w-3/4 mx-auto mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto mb-4"></div>
                            <div class="h-32 bg-gray-200 rounded-lg mb-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour gérer la modale -->
<script>
// Fonction pour ouvrir la modale avec les données d'une boutique
function openBoutiqueModal(boutique) {
    // Remplir les informations de la boutique
    document.getElementById('modalBoutiqueNom').textContent = boutique.nom;
    document.getElementById('modalBoutiqueNom2').textContent = boutique.nom;
    document.getElementById('modalBoutiqueLogo').src = boutique.logo || 'https://via.placeholder.com/150';
    document.getElementById('modalBoutiqueCategorie').textContent = boutique.categorie || 'Non spécifiée';
    document.getElementById('modalBoutiqueLivraison').textContent = boutique.livraison || 'Non spécifié';
    document.getElementById('modalBoutiqueCashback').textContent = boutique.cashback + '%';
    document.getElementById('modalBoutiqueLien').href = boutique.url || '#';
    
    // Générer les étoiles de notation
    const noteContainer = document.getElementById('modalBoutiqueNote');
    noteContainer.innerHTML = '';
    const note = parseFloat(boutique.note) || 0;
    const etoilesPleines = Math.floor(note);
    const etoileDemi = (note % 1) >= 0.5;
    
    // Ajouter les étoiles pleines
    for (let i = 0; i < etoilesPleines; i++) {
        const etoile = document.createElement('i');
        etoile.className = 'fas fa-star text-yellow-400';
        noteContainer.appendChild(etoile);
    }
    
    // Ajouter une demi-étoile si nécessaire
    if (etoileDemi) {
        const etoile = document.createElement('i');
        etoile.className = 'fas fa-star-half-alt text-yellow-400';
        noteContainer.appendChild(etoile);
    }
    
    // Ajouter les étoiles vides
    const etoilesVides = 5 - Math.ceil(note);
    for (let i = 0; i < etoilesVides; i++) {
        const etoile = document.createElement('i');
        etoile.className = 'far fa-star text-yellow-400';
        noteContainer.appendChild(etoile);
    }
    
    // Mettre à jour le nombre d'avis
    document.getElementById('modalBoutiqueAvis').textContent = `(${boutique.avis || 0} avis)`;
    
    // Afficher la modale
    document.getElementById('boutiqueModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Fonction pour fermer la modale
function closeModal() {
    document.getElementById('boutiqueModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fermer la modale en cliquant en dehors
window.onclick = function(event) {
    const modal = document.getElementById('boutiqueModal');
    if (event.target === modal) {
        closeModal();
    }
}

// Fonction pour charger les produits d'une boutique (à implémenter avec une requête AJAX)
function loadProduitsBoutique(boutiqueId) {
    // Ici, vous feriez normalement un appel AJAX pour récupérer les produits
    // Pour l'instant, nous allons simuler un chargement
    const produitsContainer = document.getElementById('produitsBoutique');
    
    // Afficher un indicateur de chargement
    produitsContainer.innerHTML = `
        <div class="col-span-2 text-center py-10">
            <div class="animate-pulse space-y-4">
                <div class="h-4 bg-gray-200 rounded w-1/4 mx-auto"></div>
                <div class="h-64 bg-gray-200 rounded-lg"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4 mx-auto"></div>
            </div>
        </div>
    `;
    
    // Simuler un délai de chargement
    setTimeout(() => {
        // Ici, vous remplaceriez par les données réelles de l'API
        const produits = [
            {
                id: 1,
                nom: 'Produit 1',
                prix: 99.99,
                image: 'https://via.placeholder.com/300x200',
                url: '#',
                cashback: '5%',
                stock: true
            },
            // Ajoutez d'autres produits ici
        ];
        
        // Afficher les produits
        afficherProduits(produits);
    }, 1000);
}

// Fonction pour afficher les produits dans la modale
function afficherProduits(produits) {
    const produitsContainer = document.getElementById('produitsBoutique');
    
    if (produits.length === 0) {
        produitsContainer.innerHTML = `
            <div class="col-span-2 text-center py-10">
                <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucun produit disponible pour le moment</p>
            </div>
        `;
        return;
    }
    
    // Créer les cartes de produits
    const produitsHTML = produits.map(produit => `
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
            <div class="relative pb-2/3">
                <img src="${produit.image}" alt="${produit.nom}" class="absolute h-full w-full object-cover">
                ${produit.stock ? '' : '<div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center"><span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Rupture</span></div>'}
            </div>
            <div class="p-4">
                <h5 class="font-semibold text-gray-900 mb-1 line-clamp-2">${produit.nom}</h5>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-lg font-bold text-blue-600">${produit.prix} €</span>
                    <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded">${produit.cashback} cashback</span>
                </div>
                <a href="${produit.url}" class="mt-3 block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded transition duration-300">
                    Voir l'offre
                </a>
            </div>
        </div>
    `).join('');
    
    produitsContainer.innerHTML = produitsHTML;
}

// Exporter les fonctions pour qu'elles soient accessibles depuis d'autres fichiers
window.BoutiqueModal = {
    open: openBoutiqueModal,
    close: closeModal
};
</script>
