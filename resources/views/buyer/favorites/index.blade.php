@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Mes favoris</h1>
        <div class="text-sm text-gray-500">
            {{ $favorites->total() }} {{ Str::plural('article', $favorites->total()) }}
        </div>
    </div>

    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($favorites as $favorite)
                @php $produit = $favorite->produit @endphp
                @if($produit)
                    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow">
                        <a href="{{ route('produits.show', $produit) }}" class="block">
                            <div class="relative" style="padding-bottom: 100%;">
                                @if($produit->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $produit->images->first()->path) }}" 
                                         alt="{{ $produit->nom }}" 
                                         class="absolute h-full w-full object-cover">
                                @else
                                    <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                                <button type="button" 
                                        class="absolute top-2 right-2 bg-white rounded-full p-2 text-red-500 hover:bg-red-50"
                                        onclick="event.preventDefault(); document.getElementById('remove-favorite-{{ $favorite->id }}').submit();">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <form id="remove-favorite-{{ $favorite->id }}" 
                                      action="{{ route('favorites.destroy', $favorite) }}" 
                                      method="POST" 
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium text-gray-900">{{ $produit->nom }}</h3>
                                <div class="mt-2">
                                    <span class="text-lg font-bold text-gray-900">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                    @if($produit->prix_compare && $produit->prix_compare > $produit->prix)
                                        <span class="ml-2 text-sm text-gray-500 line-through">{{ number_format($produit->prix_compare, 0, ',', ' ') }} FCFA</span>
                                        <span class="ml-2 text-sm text-green-600">
                                            {{ round((($produit->prix_compare - $produit->prix) / $produit->prix_compare) * 100) }}% de réduction
                                        </span>
                                    @endif
                                </div>
                                @if($produit->boutique)
                                    <div class="mt-2">
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-store mr-1"></i> {{ $produit->boutique->nom }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-8">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <i class="far fa-heart text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900">Aucun article dans vos favoris</h3>
            <p class="mt-2 text-gray-500">Ajoutez des articles à vos favoris pour les retrouver facilement plus tard.</p>
            <div class="mt-6">
                <a href="{{ route('produits.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i> Continuer vos achats
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Script pour gérer la suppression des favoris
    document.addEventListener('DOMContentLoaded', function() {
        // Écouteur d'événement pour la suppression d'un favori
        document.querySelectorAll('[id^="remove-favorite-"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('Voulez-vous vraiment retirer cet article de vos favoris ?')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection
