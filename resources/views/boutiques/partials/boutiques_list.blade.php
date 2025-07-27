@if($boutiques->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($boutiques as $boutique)
            <div class="boutique-card">
                <a href="{{ route('boutiques.show', ['id' => $boutique->id, 'slug' => $boutique->slug]) }}" class="block">
                    <div class="boutique-logo">
                        @if($boutique->logo)
                            <img src="{{ asset('storage/' . $boutique->logo) }}" alt="{{ $boutique->nom }}" class="max-h-full">
                        @else
                            <div class="text-4xl font-bold text-gray-400">{{ substr($boutique->nom, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="boutique-details">
                        <h3 class="boutique-name">{{ $boutique->nom }}</h3>
                        @if($boutique->description)
                            <p class="boutique-description">{{ $boutique->description }}</p>
                        @endif
                        <div class="boutique-meta">
                            <span class="cashback-badge">
                                Jusqu'à {{ $boutique->cashback_max }}% de cashback
                            </span>
                            @if($boutique->note_moyenne > 0)
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <span class="ml-1">{{ number_format($boutique->note_moyenne, 1) }}</span>
                                    <span class="rating-count">({{ $boutique->nb_avis }})</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($boutiques->hasPages())
        <div class="mt-8">
            {{ $boutiques->withQueryString()->links() }}
        </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-store-slash"></i>
        </div>
        <h3 class="empty-state-title">Aucune boutique disponible</h3>
        <p class="empty-state-description">
            Aucune boutique ne correspond à vos critères de recherche pour le moment.
            Revenez plus tard ou essayez d'autres filtres.
        </p>
        <a href="{{ route('boutiques.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Réinitialiser les filtres
        </a>
    </div>
@endif
