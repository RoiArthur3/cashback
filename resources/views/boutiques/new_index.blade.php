@extends('layouts.app')

@push('styles')
<style>
    .boutique-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 0.75rem;
        overflow: hidden;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .boutique-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .boutique-logo {
        height: 180px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .boutique-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .boutique-details {
        padding: 1.25rem;
    }
    .boutique-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .boutique-description {
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .boutique-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f1f5f9;
    }
    .cashback-badge {
        background: #dbeafe;
        color: #1e40af;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
    }
    .rating {
        display: flex;
        align-items: center;
        color: #f59e0b;
        font-size: 0.875rem;
    }
    .rating-count {
        color: #64748b;
        margin-left: 0.25rem;
    }
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    .empty-state-icon {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
    .empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .empty-state-description {
        color: #64748b;
        max-width: 28rem;
        margin: 0 auto 1.5rem;
    }
</style>
@endpush

@section('content')
<!-- Bannière principale avec recherche -->
<div class="bg-gradient-to-r from-blue-700 to-blue-900 py-10 md:py-16">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 text-center md:text-left mb-6 md:mb-0">
                <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-3">Nos boutiques partenaires</h1>
                <p class="text-blue-100">Découvrez nos partenaires et profitez de cashback sur vos achats</p>
            </div>
            
            <!-- Barre de recherche -->
            <div class="w-full md:w-1/2">
                <form action="{{ route('boutiques.search') }}" method="GET" class="bg-white rounded-lg shadow-lg p-1">
                    <div class="flex">
                        <input type="text" name="q" value="{{ request('q') }}" class="w-full px-4 py-3 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Rechercher une boutique...">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="bg-white shadow-sm sticky top-0 z-10">
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1">
                <form action="{{ route('boutiques.index') }}" method="GET" class="flex">
                    <select name="categorie" onchange="this.form.submit()" class="w-full md:w-auto border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="trier_par" onchange="this.form.submit()" class="ml-2 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="populaires" {{ request('trier_par') == 'populaires' ? 'selected' : '' }}>Populaires</option>
                        <option value="nouveautes" {{ request('trier_par') == 'nouveautes' ? 'selected' : '' }}>Nouveautés</option>
                        <option value="cashback_eleve" {{ request('trier_par') == 'cashback_eleve' ? 'selected' : '' }}>Cashback élevé</option>
                        <option value="notes_elevees" {{ request('trier_par') == 'notes_elevees' ? 'selected' : '' }}>Notes élevées</option>
                    </select>
                    
                    @if(request()->hasAny(['q', 'categorie', 'trier_par']))
                        <a href="{{ route('boutiques.index') }}" class="ml-2 flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-times mr-1"></i> Réinitialiser
                        </a>
                    @endif
                </form>
            </div>
            
            <div class="text-sm text-gray-500">
                {{ $boutiques->total() }} {{ $boutiques->total() > 1 ? 'boutiques trouvées' : 'boutique trouvée' }}
            </div>
        </div>
    </div>
</div>

<!-- Liste des boutiques -->
<div class="container mx-auto px-4 py-8">
    <div id="boutiques-container">
        @include('boutiques.partials.boutiques_list', ['boutiques' => $boutiques])
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Écouter les changements sur les filtres
        const filterForm = document.querySelector('form[action="{{ route("boutiques.index") }}"]');
        const searchForm = document.querySelector('form[action="{{ route("boutiques.search") }}"]');
        const boutiquesContainer = document.getElementById('boutiques-container');
        let loading = false;

        // Fonction pour charger les boutiques avec les filtres
        function loadBoutiques(url) {
            if (loading) return;
            
            loading = true;
            
            // Afficher un indicateur de chargement
            boutiquesContainer.innerHTML = `
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
                </div>
            `;
            
            // Faire la requête AJAX
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.text())
            .then(html => {
                boutiquesContainer.innerHTML = html;
                updateURL(url);
            })
            .catch(error => {
                console.error('Erreur lors du chargement des boutiques:', error);
                boutiquesContainer.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-red-500 text-4xl mb-4">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Une erreur est survenue</h3>
                        <p class="text-gray-600 mb-4">Impossible de charger les boutiques. Veuillez réessayer.</p>
                        <button onclick="window.location.reload()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-sync-alt mr-2"></i> Réessayer
                        </button>
                    </div>
                `;
            })
            .finally(() => {
                loading = false;
            });
        }
        
        // Mettre à jour l'URL sans recharger la page
        function updateURL(url) {
            const newUrl = new URL(url);
            window.history.pushState({}, '', newUrl.pathname + newUrl.search);
        }
        
        // Gérer les changements de filtres
        if (filterForm) {
            filterForm.addEventListener('change', function(e) {
                if (e.target.tagName === 'SELECT' || e.target.tagName === 'INPUT') {
                    const formData = new FormData(filterForm);
                    const searchParams = new URLSearchParams(formData);
                    loadBoutiques(`{{ route('boutiques.index') }}?${searchParams.toString()}`);
                }
            });
        }
        
        // Gérer la soumission du formulaire de recherche
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(searchForm);
                const searchParams = new URLSearchParams(formData);
                
                // Ajouter les paramètres de tri s'ils existent
                const trierPar = document.querySelector('select[name="trier_par"]');
                const categorie = document.querySelector('select[name="categorie"]');
                
                if (trierPar && trierPar.value) {
                    searchParams.set('trier_par', trierPar.value);
                }
                
                if (categorie && categorie.value) {
                    searchParams.set('categorie', categorie.value);
                }
                
                loadBoutiques(`{{ route('boutiques.index') }}?${searchParams.toString()}`);
            });
        }
        
        // Gérer la pagination AJAX
        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = e.target.closest('a').href;
                loadBoutiques(url);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
        
        // Gérer le bouton de réinitialisation
        const resetBtn = document.querySelector('a[href="{{ route("boutiques.index") }}"]');
        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                if (window.location.search) {
                    e.preventDefault();
                    loadBoutiques('{{ route("boutiques.index") }}');
                }
            });
        }
    });
</script>
@endpush
