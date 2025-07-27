@extends('admin.layouts.app')

@section('title', $campaign->exists ? 'Modifier la campagne' : 'Nouvelle campagne')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .price-calculator { position: sticky; top: 1rem; }
    .form-section { @apply bg-white shadow overflow-hidden sm:rounded-lg mb-6; }
    .form-section-title { @apply px-4 py-5 sm:px-6 border-b border-gray-200; }
    .form-section-content { @apply px-4 py-5 sm:p-6; }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form id="campaignForm" action="{{ $campaign->exists ? route('admin.campaigns.update', $campaign) : route('admin.campaigns.store') }}" method="POST">
        @csrf
        @if($campaign->exists) @method('PUT') @endif

        <div class="lg:grid lg:grid-cols-3 lg:gap-6">
            <div class="lg:col-span-2">
                <!-- Informations de base -->
                <div class="form-section">
                    <div class="form-section-title">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Informations de la campagne
                        </h3>
                    </div>
                    <div class="form-section-content">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nom de la campagne <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $campaign->name) }}" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="sm:col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Description
                                </label>
                                <div class="mt-1">
                                    <textarea id="description" name="description" rows="3"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description', $campaign->description) }}</textarea>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="advertiser_id" class="block text-sm font-medium text-gray-700">
                                    Annonceur <span class="text-red-500">*</span>
                                </label>
                                <select id="advertiser_id" name="advertiser_id" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Sélectionner un annonceur</option>
                                    @foreach($advertisers as $advertiser)
                                        <option value="{{ $advertiser->id }}" {{ old('advertiser_id', $campaign->advertiser_id) == $advertiser->id ? 'selected' : '' }}>
                                            {{ $advertiser->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    Statut <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach(['draft' => 'Brouillon', 'pending' => 'En attente', 'active' => 'Active', 'paused' => 'En pause'] as $value => $label)
                                        <option value="{{ $value }}" {{ old('status', $campaign->status) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Période de diffusion -->
                <div class="form-section mt-6">
                    <div class="form-section-title">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Période de diffusion
                        </h3>
                    </div>
                    <div class="form-section-content">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">
                                    Date de début <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="start_date" id="start_date" 
                                    value="{{ old('start_date', $campaign->start_date ? $campaign->start_date->format('Y-m-d') : '') }}" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md datepicker">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">
                                    Date de fin <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="end_date" id="end_date" 
                                    value="{{ old('end_date', $campaign->end_date ? $campaign->end_date->format('Y-m-d') : '') }}" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md datepicker">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ciblage -->
                <div class="form-section mt-6">
                    <div class="form-section-title">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Critères de ciblage
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Définissez précisément votre audience cible
                        </p>
                    </div>
                    <div class="form-section-content">
                        <input type="hidden" name="targeting_criteria" id="targeting_criteria" value='{{ json_encode(old('targeting_criteria', $campaign->targeting_criteria ?? [])) }}'>
                        
                        <!-- Connexion récente -->
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Connexion récente</h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                @foreach([
                                    'high' => ['reach' => '> 500', 'label' => 'Élevé', 'desc' => 'Plus de 500 utilisateurs'],
                                    'medium' => ['reach' => '100-500', 'label' => 'Moyen', 'desc' => '100 à 500 utilisateurs'],
                                    'low' => ['reach' => '< 100', 'label' => 'Faible', 'desc' => 'Moins de 100 utilisateurs']
                                ] as $value => $option)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="recent_activity_{{ $value }}" name="recent_activity" type="radio" value="{{ $value }}" 
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                {{ (old('targeting_criteria.recent_activity.reach', $campaign->targeting_criteria['recent_activity']['reach'] ?? 0) > ($value === 'high' ? 500 : ($value === 'medium' ? 100 : 0))) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="recent_activity_{{ $value }}" class="font-medium text-gray-700">{{ $option['label'] }}</label>
                                            <p class="text-gray-500">{{ $option['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tranche d'âge -->
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Tranche d'âge</h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="age_min" class="block text-sm font-medium text-gray-700">Âge minimum</label>
                                    <select id="age_min" name="age_min" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @for($i = 13; $i <= 65; $i++)
                                            <option value="{{ $i }}" {{ old('targeting_criteria.age_range.min', $campaign->targeting_criteria['age_range']['min'] ?? 18) == $i ? 'selected' : '' }}>{{ $i }} ans</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="age_max" class="block text-sm font-medium text-gray-700">Âge maximum</label>
                                    <select id="age_max" name="age_max" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @for($i = 18; $i <= 100; $i++)
                                            <option value="{{ $i }}" {{ old('targeting_criteria.age_range.max', $campaign->targeting_criteria['age_range']['max'] ?? 65) == $i ? 'selected' : '' }}>{{ $i }} ans</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Localisation -->
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Localisation</h4>
                            <div class="space-y-4">
                                @foreach([
                                    'neighborhood' => ['label' => 'Quartier spécifique', 'desc' => 'Cibler un quartier précis'],
                                    'city' => ['label' => 'Ville entière', 'desc' => 'Cibler toute la ville']
                                ] as $value => $option)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="location_{{ $value }}" name="location_type" type="radio" value="{{ $value }}"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                {{ old('targeting_criteria.location_type', $campaign->targeting_criteria['location_type'] ?? '') == $value ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="location_{{ $value }}" class="font-medium text-gray-700">{{ $option['label'] }}</label>
                                            <p class="text-gray-500">{{ $option['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Centres d'intérêt -->
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Centres d'intérêt</h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                                @foreach(['mode', 'technologie', 'voyage', 'sport', 'cuisine', 'musique', 'art', 'lecture', 'cinema', 'jeux'] as $interest)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="interest_{{ $interest }}" name="interests[]" type="checkbox" value="{{ $interest }}"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                                {{ in_array($interest, old('targeting_criteria.interests', $campaign->targeting_criteria['interests'] ?? [])) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="interest_{{ $interest }}" class="font-medium text-gray-700">{{ ucfirst($interest) }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Canaux de diffusion -->
                <div class="form-section mt-6">
                    <div class="form-section-title">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Canaux de diffusion
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Sélectionnez où votre publicité sera diffusée
                        </p>
                    </div>
                    <div class="form-section-content">
                        <input type="hidden" name="channels" id="channels" value='{{ json_encode(old('channels', $campaign->channels ?? [])) }}'>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach([
                                'web' => ['icon' => 'desktop', 'label' => 'Web (Desktop)', 'description' => 'Version ordinateur'],
                                'mobile_web' => ['icon' => 'mobile-alt', 'label' => 'Mobile Web', 'description' => 'Version mobile'],
                                'app' => ['icon' => 'mobile', 'label' => 'Application Mobile', 'description' => 'iOS & Android'],
                                'email' => ['icon' => 'envelope', 'label' => 'Email', 'description' => 'Newsletter ciblée'],
                                'popup' => ['icon' => 'window-maximize', 'label' => 'Popup In-App', 'description' => 'Fenêtre contextuelle']
                            ] as $value => $channel)
                                <div class="channel-option relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 cursor-pointer" 
                                     data-value="{{ $value }}">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-indigo-100">
                                            <i class="fas fa-{{ $channel['icon'] }} text-indigo-600"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        <p class="text-sm font-medium text-gray-900">{{ $channel['label'] }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $channel['description'] }}</p>
                                    </div>
                                    <div class="check-icon hidden">
                                        <svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calculateur de prix -->
            <div class="lg:col-span-1">
                <div class="price-calculator bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-calculator mr-2 text-indigo-600"></i> Calculateur de prix
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700">
                                Prix de base (FCFA/jour) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="base_price" id="base_price" min="1000" step="500" 
                                   value="{{ old('base_price', $campaign->base_price ?? 3000) }}" required
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Résumé des coûts</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <dt class="text-gray-500">Prix de base:</dt>
                                    <dd id="base_price_display" class="font-medium">0 FCFA</dd>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <dt class="text-gray-500">Majoration ciblage:</dt>
                                    <dd id="targeting_surcharge" class="text-green-600">+0%</dd>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <dt class="text-gray-500">Majoration canaux:</dt>
                                    <dd id="channel_surcharge" class="text-green-600">+0%</dd>
                                </div>
                                <div class="pt-2 mt-2 border-t border-gray-200">
                                    <div class="flex justify-between text-base font-medium">
                                        <dt>Prix journalier:</dt>
                                        <dd id="daily_price" class="text-indigo-600">0 FCFA</dd>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-500">
                                        <dt>Prix total estimé (<span id="days_count">0</span> jours):</dt>
                                        <dd id="total_price" class="font-medium">0 FCFA</dd>
                                    </div>
                                </div>
                            </dl>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Estimation de portée</h4>
                            <div class="text-sm text-gray-600">
                                <p>Portée estimée: <span id="estimated_reach" class="font-medium">0</span> utilisateurs</p>
                                <p class="text-xs text-gray-500 mt-1">Basé sur vos critères de ciblage</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ $campaign->exists ? 'Mettre à jour' : 'Créer' }} la campagne
                            </button>
                            <a href="{{ route('admin.campaigns.index') }}" class="mt-2 w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du datepicker
    flatpickr(".datepicker", {
        locale: "fr",
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    // Gestion des canaux sélectionnés
    const channelsInput = document.getElementById('channels');
    const channelOptions = document.querySelectorAll('.channel-option');
    let selectedChannels = JSON.parse(channelsInput.value || '[]');

    function updateChannelSelection() {
        channelOptions.forEach(option => {
            const value = option.dataset.value;
            const isSelected = selectedChannels.includes(value);
            option.classList.toggle('border-indigo-500', isSelected);
            option.classList.toggle('ring-2', isSelected);
            option.classList.toggle('ring-indigo-500', isSelected);
            option.querySelector('.check-icon').classList.toggle('hidden', !isSelected);
        });
        channelsInput.value = JSON.stringify(selectedChannels);
        calculatePrice();
    }

    channelOptions.forEach(option => {
        option.addEventListener('click', () => {
            const value = option.dataset.value;
            const index = selectedChannels.indexOf(value);
            
            if (index === -1) {
                selectedChannels.push(value);
            } else {
                selectedChannels.splice(index, 1);
            }
            
            updateChannelSelection();
        });
    });

    // Initialisation des canaux sélectionnés
    updateChannelSelection();

    // Gestion du formulaire de ciblage
    const targetingForm = document.getElementById('campaignForm');
    const targetingInput = document.getElementById('targeting_criteria');
    let targetingData = JSON.parse(targetingInput.value || '{}');

    function updateTargetingData() {
        // Connexion récente
        const recentActivity = document.querySelector('input[name="recent_activity"]:checked');
        if (recentActivity) {
            const reachMap = { 'high': 501, 'medium': 250, 'low': 50 };
            targetingData.recent_activity = { reach: reachMap[recentActivity.value] || 0 };
        }

        // Tranche d'âge
        const ageMin = parseInt(document.getElementById('age_min').value) || 18;
        const ageMax = parseInt(document.getElementById('age_max').value) || 65;
        targetingData.age_range = { min: ageMin, max: ageMax };

        // Localisation
        const locationType = document.querySelector('input[name="location_type"]:checked');
        if (locationType) {
            targetingData.location_type = locationType.value;
        }

        // Centres d'intérêt
        const interests = [];
        document.querySelectorAll('input[name^="interests"]:checked').forEach(checkbox => {
            interests.push(checkbox.value);
        });
        targetingData.interests = interests;

        // Mise à jour du champ caché
        targetingInput.value = JSON.stringify(targetingData);
        
        // Recalcul du prix
        calculatePrice();
    }

    // Écouteurs d'événements pour le recalcul
    document.querySelectorAll('input[type="radio"][name="recent_activity"], input[type="radio"][name="location_type"], input[type="checkbox"][name^="interests"], #age_min, #age_max, #base_price, #start_date, #end_date').forEach(input => {
        input.addEventListener('change', updateTargetingData);
    });

    // Calcul du prix
    function calculatePrice() {
        const basePrice = parseFloat(document.getElementById('base_price').value) || 0;
        const startDate = new Date(document.getElementById('start_date').value);
        const endDate = new Date(document.getElementById('end_date').value);
        const days = Math.max(1, Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1);
        
        // Calcul des majorations
        let targetingSurcharge = 0;
        
        // Majoration pour connexion récente
        const recentActivity = document.querySelector('input[name="recent_activity"]:checked');
        if (recentActivity) {
            targetingSurcharge += recentActivity.value === 'high' ? 0.30 : 
                                 recentActivity.value === 'medium' ? 0.15 : 0.05;
        }
        
        // Majoration pour tranche d'âge
        const ageMin = parseInt(document.getElementById('age_min').value) || 18;
        const ageMax = parseInt(document.getElementById('age_max').value) || 65;
        const ageRange = ageMax - ageMin;
        targetingSurcharge += ageRange <= 5 ? 0.20 : 0.10;
        
        // Majoration pour localisation
        const locationType = document.querySelector('input[name="location_type"]:checked');
        if (locationType) {
            targetingSurcharge += locationType.value === 'neighborhood' ? 0.25 : 0.10;
        }
        
        // Majoration pour centres d'intérêt
        const interests = document.querySelectorAll('input[name^="interests"]:checked');
        if (interests.length >= 3) {
            targetingSurcharge += 0.20;
        } else if (interests.length > 0) {
            targetingSurcharge += 0.10;
        }
        
        // Majoration pour canaux
        let channelMultiplier = 1.0;
        selectedChannels.forEach(channel => {
            const multipliers = {
                'web': 1.0,
                'mobile_web': 1.1,
                'app': 1.2,
                'email': 1.15,
                'popup': 1.25
            };
            channelMultiplier = Math.max(channelMultiplier, multipliers[channel] || 1.0);
        });
        
        // Calcul du prix final
        const finalPrice = basePrice * (1 + targetingSurcharge) * channelMultiplier;
        const totalPrice = finalPrice * days;
        
        // Mise à jour de l'interface
        document.getElementById('base_price_display').textContent = basePrice.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('targeting_surcharge').textContent = `+${(targetingSurcharge * 100).toFixed(0)}%`;
        document.getElementById('channel_surcharge').textContent = `+${((channelMultiplier - 1) * 100).toFixed(0)}%`;
        document.getElementById('daily_price').textContent = Math.round(finalPrice).toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('days_count').textContent = days;
        document.getElementById('total_price').textContent = Math.round(totalPrice).toLocaleString('fr-FR') + ' FCFA';
        
        // Estimation de la portée
        const estimatedReach = recentActivity ? 
            (recentActivity.value === 'high' ? 750 : recentActivity.value === 'medium' ? 300 : 75) : 0;
        document.getElementById('estimated_reach').textContent = estimatedReach.toLocaleString('fr-FR');
    }
    
    // Initialisation
    updateTargetingData();
    
    // Écouteur pour le changement de prix de base
    document.getElementById('base_price').addEventListener('input', calculatePrice);
    
    // Écouteur pour le changement de dates
    document.getElementById('start_date').addEventListener('change', calculatePrice);
    document.getElementById('end_date').addEventListener('change', calculatePrice);
});
</script>
@endpush
