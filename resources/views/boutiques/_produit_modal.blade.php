<!-- Modal Produit -->
<div id="produitModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-4 mx-auto p-5 w-11/12 max-w-6xl rounded-lg shadow-2xl bg-white">
        <!-- Bouton fermer -->
        <button onclick="ProduitModal.close()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-2xl"></i>
        </button>

        <!-- Contenu du produit -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Galerie d'images -->
            <div class="space-y-4">
                <!-- Image principale -->
                <div class="relative overflow-hidden rounded-lg bg-gray-100" style="padding-bottom: 100%;">
                    <img id="produitImagePrincipale" src="" alt="Produit" class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300">
                    <div class="absolute top-4 left-4">
                        <span id="produitBadgeNouveaute" class="hidden bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Nouveauté</span>
                        <span id="produitBadgeTopVente" class="hidden bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Top vente</span>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <span id="produitBadgeCashback" class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full"></span>
                    </div>
                </div>
                
                <!-- Miniatures -->
                <div id="produitMiniatures" class="grid grid-cols-4 gap-3">
                    <!-- Les miniatures seront ajoutées ici dynamiquement -->
                </div>
            </div>

            <!-- Détails du produit -->
            <div class="pt-4">
                <!-- Boutique et note -->
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center">
                        <span id="produitBoutique" class="text-sm font-medium text-gray-700"></span>
                        <span class="mx-2 text-gray-300">•</span>
                        <div id="produitNote" class="flex items-center">
                            <!-- Les étoiles seront ajoutées ici dynamiquement -->
                        </div>
                        <span id="produitAvis" class="text-xs text-gray-500 ml-1"></span>
                    </div>
                    <button id="produitFavori" class="text-gray-400 hover:text-red-500">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                </div>

                <!-- Nom du produit -->
                <h1 id="produitNom" class="text-2xl font-bold text-gray-900 mb-3"></h1>

                <!-- Prix -->
                <div class="mb-6">
                    <div class="flex items-baseline">
                        <span id="produitPrix" class="text-3xl font-bold text-gray-900"></span>
                        <span id="produitPrixBarre" class="ml-2 text-lg text-gray-500 line-through"></span>
                        <span id="produitEconomie" class="ml-3 bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-full"></span>
                    </div>
                    <div class="mt-1">
                        <span id="produitCashbackMontant" class="text-green-600 font-medium"></span>
                        <span class="text-sm text-gray-500">de cashback après livraison</span>
                    </div>
                </div>

                <!-- Sélecteur de variantes (taille, couleur, etc.) -->
                <div id="produitVariantes" class="space-y-4 mb-6">
                    <!-- Les variantes seront ajoutées ici dynamiquement -->
                </div>

                <!-- Quantité -->
                <div class="mb-6">
                    <label for="quantite" class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
                    <div class="flex items-center">
                        <button id="btnMoins" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-l-md bg-gray-50 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <input type="number" id="quantite" value="1" min="1" class="w-16 h-10 text-center border-t border-b border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <button id="btnPlus" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-r-md bg-gray-50 text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="space-y-3">
                    <button id="btnAjouterPanier" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                        <i class="fas fa-shopping-cart mr-2"></i> Ajouter au panier
                    </button>
                    <button id="btnCommander" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                        <i class="fas fa-bolt mr-2"></i> Commander maintenant
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-2">Paiement à la livraison disponible</p>
                </div>

                <!-- Livraison et retours -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <i class="fas fa-truck text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-gray-900">Livraison</h4>
                                <p id="produitLivraison" class="text-sm text-gray-500"></p>
                                <p id="produitLivraisonGratuite" class="text-sm text-green-600 font-medium"></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-undo-alt text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-gray-900">Retours faciles</h4>
                                <p class="text-sm text-gray-500">Retours sous 30 jours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description et détails -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                    <div id="produitDescription" class="prose max-w-none text-gray-600">
                        <!-- La description sera insérée ici -->
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Détails du produit</h3>
                    <dl id="produitDetails" class="space-y-3">
                        <!-- Les détails seront insérés ici -->
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour gérer la modale produit -->
<script>
// Fonction pour ouvrir la modale avec les données d'un produit
function openProduitModal(produit) {
    // Mettre à jour les informations de base
    document.getElementById('produitNom').textContent = produit.nom;
    document.getElementById('produitBoutique').textContent = produit.boutique;
    document.getElementById('produitPrix').textContent = produit.prix.toFixed(2) + ' €';
    
    // Prix barré et économie
    if (produit.prix_barre > produit.prix) {
        document.getElementById('produitPrixBarre').textContent = produit.prix_barre.toFixed(2) + ' €';
        const economie = produit.prix_barre - produit.prix;
        document.getElementById('produitEconomie').textContent = `Économisez ${economie.toFixed(2)} €`;
        document.getElementById('produitEconomie').classList.remove('hidden');
    } else {
        document.getElementById('produitPrixBarre').textContent = '';
        document.getElementById('produitEconomie').classList.add('hidden');
    }
    
    // Cashback
    const montantCashback = (produit.prix * produit.cashback / 100).toFixed(2);
    document.getElementById('produitBadgeCashback').textContent = `${produit.cashback}% cashback`;
    document.getElementById('produitCashbackMontant').textContent = `Jusqu'à ${montantCashback} €`;
    
    // Badges
    document.getElementById('produitBadgeNouveaute').classList.toggle('hidden', !produit.nouveaute);
    document.getElementById('produitBadgeTopVente').classList.toggle('hidden', !produit.top_vente);
    
    // Note et avis
    const noteContainer = document.getElementById('produitNote');
    noteContainer.innerHTML = '';
    const note = parseFloat(produit.note) || 0;
    const etoilesPleines = Math.floor(note);
    const etoileDemi = (note % 1) >= 0.5;
    
    // Ajouter les étoiles
    for (let i = 0; i < 5; i++) {
        const etoile = document.createElement('i');
        if (i < etoilesPleines) {
            etoile.className = 'fas fa-star text-yellow-400 text-sm';
        } else if (i === etoilesPleines && etoileDemi) {
            etoile.className = 'fas fa-star-half-alt text-yellow-400 text-sm';
        } else {
            etoile.className = 'far fa-star text-yellow-400 text-sm';
        }
        noteContainer.appendChild(etoile);
    }
    
    document.getElementById('produitAvis').textContent = `(${produit.avis || 0})`;
    
    // Images
    const images = produit.images || [produit.image];
    const imagePrincipale = document.getElementById('produitImagePrincipale');
    const miniaturesContainer = document.getElementById('produitMiniatures');
    
    // Définir l'image principale
    imagePrincipale.src = images[0];
    imagePrincipale.alt = produit.nom;
    
    // Créer les miniatures
    miniaturesContainer.innerHTML = '';
    images.forEach((img, index) => {
        const imgElement = document.createElement('img');
        imgElement.src = img;
        imgElement.alt = `${produit.nom} - Vue ${index + 1}`;
        imgElement.className = 'h-20 w-full object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-blue-500';
        imgElement.onclick = () => {
            imagePrincipale.src = img;
            // Mettre à jour la classe active sur les miniatures
            document.querySelectorAll('#produitMiniatures img').forEach(el => {
                el.classList.remove('border-blue-500');
            });
            imgElement.classList.add('border-blue-500');
        };
        
        // Activer la première miniature
        if (index === 0) {
            imgElement.classList.add('border-blue-500');
        }
        
        miniaturesContainer.appendChild(imgElement);
    });
    
    // Livraison
    const livraisonElement = document.getElementById('produitLivraison');
    const livraisonGratuiteElement = document.getElementById('produitLivraisonGratuite');
    
    if (produit.livraison_gratuite) {
        livraisonElement.textContent = 'Livraison standard';
        livraisonGratuiteElement.textContent = 'Livraison gratuite';
    } else {
        livraisonElement.textContent = 'Frais de livraison à partir de 3,99 €';
        livraisonGratuiteElement.textContent = '';
    }
    
    // Description
    const descriptionElement = document.getElementById('produitDescription');
    descriptionElement.innerHTML = produit.description || '<p>Aucune description disponible pour ce produit.</p>';
    
    // Détails
    const detailsElement = document.getElementById('produitDetails');
    detailsElement.innerHTML = '';
    
    const details = {
        'Marque': produit.marque || 'Non spécifiée',
        'Catégorie': produit.categorie || 'Non spécifiée',
        'Référence': produit.reference || 'N/A',
        'Disponibilité': produit.stock > 0 ? 'En stock' : 'Rupture de stock',
        'Poids': produit.poids ? `${produit.poids} kg` : 'Non spécifié',
        'Dimensions': produit.dimensions || 'Non spécifiées'
    };
    
    for (const [label, value] of Object.entries(details)) {
        const dt = document.createElement('dt');
        dt.className = 'text-sm font-medium text-gray-500';
        dt.textContent = label;
        
        const dd = document.createElement('dd');
        dd.className = 'mt-1 text-sm text-gray-900';
        dd.textContent = value;
        
        const div = document.createElement('div');
        div.appendChild(dt);
        div.appendChild(dd);
        
        detailsElement.appendChild(div);
    }
    
    // Gestion de la quantité
    const quantiteInput = document.getElementById('quantite');
    const btnMoins = document.getElementById('btnMoins');
    const btnPlus = document.getElementById('btnPlus');
    
    btnMoins.onclick = () => {
        const valeur = parseInt(quantiteInput.value) || 1;
        if (valeur > 1) {
            quantiteInput.value = valeur - 1;
        }
    };
    
    btnPlus.onclick = () => {
        const valeur = parseInt(quantiteInput.value) || 1;
        quantiteInput.value = valeur + 1;
    };
    
    // Gestion du bouton favori
    const btnFavori = document.getElementById('produitFavori');
    let estFavori = false;
    
    btnFavori.onclick = () => {
        estFavori = !estFavori;
        const icon = btnFavori.querySelector('i');
        if (estFavori) {
            icon.className = 'fas fa-heart text-xl text-red-500';
            // Ici, vous pourriez ajouter une notification ou une animation
        } else {
            icon.className = 'far fa-heart text-xl';
        }
    };
    
    // Gestion des boutons d'action
    document.getElementById('btnAjouterPanier').onclick = () => {
        const quantite = parseInt(quantiteInput.value) || 1;
        // Ici, vous pourriez ajouter la logique pour ajouter au panier
        alert(`Ajout de ${quantite} ${produit.nom} au panier`);
    };
    
    document.getElementById('btnCommander').onclick = () => {
        const quantite = parseInt(quantiteInput.value) || 1;
        // Ici, vous pourriez rediriger vers la page de commande
        alert(`Commande de ${quantite} ${produit.nom}`);
    };
    
    // Afficher la modale
    document.getElementById('produitModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Fonction pour fermer la modale
function closeProduitModal() {
    document.getElementById('produitModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fermer la modale en cliquant en dehors
window.onclick = function(event) {
    const modal = document.getElementById('produitModal');
    if (event.target === modal) {
        closeProduitModal();
    }
}

// Exporter les fonctions pour qu'elles soient accessibles depuis d'autres fichiers
window.ProduitModal = {
    open: openProduitModal,
    close: closeProduitModal
};
</script>
