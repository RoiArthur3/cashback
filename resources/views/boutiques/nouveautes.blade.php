@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-blue-700">Nouveautés</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($boutiques as $boutique)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                <a href="{{ route('boutiques.show', ['boutique' => $boutique->id]) }}" class="block">
                    <div class="h-40 flex items-center justify-center bg-gray-100">
                        @if($boutique->logo)
                            <img src="{{ asset('storage/' . $boutique->logo) }}" alt="{{ $boutique->nom }}" class="max-h-full">
                        @else
                            <span class="text-4xl font-bold text-gray-400">{{ substr($boutique->nom, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $boutique->nom }}</h3>
                        <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $boutique->description }}</p>
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full mb-2">Ouvert le {{ $boutique->created_at->format('d/m/Y') }}</span>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-green-600 font-bold">Jusqu'à {{ $boutique->cashback_max }}% cashback</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-4 text-center py-10">
                <i class="fas fa-store text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucune nouveauté pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
