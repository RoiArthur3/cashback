@extends('admin.layouts.app')

@section('title', 'Gestion des Campagnes Publicitaires')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Gestion des Campagnes</h1>
        <a href="{{ route('admin.campaigns.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-plus mr-2"></i> Nouvelle Campagne
        </a>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <form action="{{ route('admin.campaigns.index') }}" method="GET" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:space-x-4">
            <div class="flex-1">
                <label for="search" class="sr-only">Rechercher</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Rechercher une campagne...">
                </div>
            </div>
            <div>
                <select name="status" id="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">Tous les statuts</option>
                    @foreach(['draft' => 'Brouillon', 'pending' => 'En attente', 'active' => 'Active', 'paused' => 'En pause', 'completed' => 'Terminée', 'rejected' => 'Rejetée'] as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Filtrer
            </button>
        </form>
    </div>

    <!-- Liste des campagnes -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($campaigns as $campaign)
            <li class="hover:bg-gray-50">
                <a href="{{ route('admin.campaigns.show', $campaign) }}" class="block">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-indigo-600 truncate">{{ $campaign->name }}</p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $campaign->status_badge }}">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-user mr-1.5 text-gray-400"></i>
                                    {{ $campaign->advertiser->name }}
                                </p>
                                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                    <i class="fas fa-calendar-alt mr-1.5 text-gray-400"></i>
                                    {{ $campaign->formatted_period }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <i class="fas fa-wallet mr-1.5 text-gray-400"></i>
                                <p>{{ $campaign->formatted_budget }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @empty
            <li class="px-4 py-12 text-center text-gray-500">
                <i class="fas fa-ad text-4xl mb-2 text-gray-300"></i>
                <p class="text-lg font-medium text-gray-900">Aucune campagne trouvée</p>
                <p class="mt-1">Commencez par créer votre première campagne publicitaire.</p>
            </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    @if($campaigns->hasPages())
    <div class="mt-4">
        {{ $campaigns->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
