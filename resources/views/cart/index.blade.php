@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Votre panier</h1>
    
    @if (Cart::count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="hidden md:grid grid-cols-6 bg-gray-100 p-4 font-semibold">
                <div class="col-span-2">Produit</div>
                <div class="text-center">Prix</div>
                <div class="text-center">Quantité</div>
                <div class="text-center">Total</div>
                <div class="text-right">Actions</div>
            </div>
            
            @foreach (Cart::content() as $id => $item)
                <div class="grid grid-cols-1 md:grid-cols-6 p-4 border-b border-gray-200 items-center">
                    <div class="col-span-2 flex items-center mb-4 md:mb-0">
                        <img src="{{ $item->options->image ?? 'https://via.placeholder.com/100' }}" 
                             alt="{{ $item['name'] }}" 
                             class="w-20 h-20 object-cover rounded mr-4">
                        <div>
                            <h3 class="font-medium">{{ $item['name'] }}</h3>
                            <p class="text-sm text-gray-600">Boutique: {{ $item['options']['boutique_name'] ?? 'Non spécifiée' }}</p>
                        </div>
                    </div>
                    
                    <div class="text-center mb-4 md:mb-0">
                        <span class="font-medium">{{ number_format($item['price'], 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="flex justify-center mb-4 md:mb-0">
                        <form action="{{ route('cart.update', $item->rowId) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PUT')
                            <input type="number" name="qty" value="{{ $item['quantity'] }}" min="1" 
                                   class="w-16 text-center border rounded py-1 mr-2">
                            <button type="submit" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="text-center font-medium mb-4 md:mb-0">
                        {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA
                    </div>
                    
                    <div class="text-right">
                        <form action="{{ route('cart.destroy', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            
            <div class="p-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <form action="{{ route('cart.empty') }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash mr-1"></i> Vider le panier
                            </button>
                        </form>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-xl font-bold mb-2">
                            Total : {{ Cart::total() }} FCFA
                        </div>
                        <a href="{{ route('checkout') }}" 
                           class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                            Passer la commande
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-5xl mb-4">🛒</div>
            <h2 class="text-2xl font-semibold mb-4">Votre panier est vide</h2>
            <p class="text-gray-600 mb-6">Parcourez nos produits et ajoutez des articles à votre panier</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Voir les produits
            </a>
        </div>
    @endif
</div>
@endsection
