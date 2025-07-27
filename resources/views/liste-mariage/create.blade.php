@extends('layouts.app')

@section('title', 'Créer une liste de mariage')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Nouvelle liste de mariage</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Remplissez les informations de base pour créer votre liste de mariage.</p>
            </div>
            
            <form action="{{ route('liste-mariage.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200">
                @csrf
                
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-6">
                        <!-- Informations de base -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Informations de base</h4>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="titre" class="block text-sm font-medium text-gray-700">Titre de la liste <span class="text-red-500">*</span></label>
                                    <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('titre')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <div class="mt-1">
                                        <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description') }}</textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Décrivez votre liste pour vos invités (optionnel).</p>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="date_mariage" class="block text-sm font-medium text-gray-700">Date du mariage <span class="text-red-500">*</span></label>
                                    <input type="date" name="date_mariage" id="date_mariage" value="{{ old('date_mariage') }}" min="{{ now()->addDay()->format('Y-m-d') }}" required class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('date_mariage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="theme" class="block text-sm font-medium text-gray-700">Thème <span class="text-red-500">*</span></label>
                                    <select id="theme" name="theme" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm rounded-md">
                                        <option value="classique" {{ old('theme') == 'classique' ? 'selected' : '' }}>Classique</option>
                                        <option value="moderne" {{ old('theme') == 'moderne' ? 'selected' : '' }}>Moderne</option>
                                        <option value="romantique" {{ old('theme') == 'romantique' ? 'selected' : '' }}>Romantique</option>
                                        <option value="naturel" {{ old('theme') == 'naturel' ? 'selected' : '' }}>Naturel</option>
                                    </select>
                                    @error('theme')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-6">
                                    <label class="block text-sm font-medium text-gray-700">Image de couverture</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="image_couverture" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500">
                                                    <span>Télécharger une image</span>
                                                    <input id="image_couverture" name="image_couverture" type="file" class="sr-only">
                                                </label>
                                                <p class="pl-1">ou glisser-déposer</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                                        </div>
                                    </div>
                                    @error('image_couverture')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Paramètres de confidentialité -->
                        <div class="pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Paramètres de confidentialité</h4>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input id="est_publique" name="est_publique" type="checkbox" value="1" class="focus:ring-amber-500 h-4 w-4 text-amber-600 border-gray-300 rounded" {{ old('est_publique', true) ? 'checked' : '' }}>
                                    <label for="est_publique" class="ml-2 block text-sm text-gray-700">
                                        Rendre cette liste publique (visible par tous)
                                    </label>
                                </div>

                                <div id="motDePasseContainer" class="hidden">
                                    <label for="mot_de_passe" class="block text-sm font-medium text-gray-700">Mot de passe (optionnel)</label>
                                    <input type="password" name="mot_de_passe" id="mot_de_passe" class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <p class="mt-1 text-sm text-gray-500">Protégez votre liste avec un mot de passe (4 caractères minimum).</p>
                                    @error('mot_de_passe')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Coordonnées -->
                        <div class="pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Coordonnées</h4>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="adresse_livraison" class="block text-sm font-medium text-gray-700">Adresse de livraison <span class="text-red-500">*</span></label>
                                    <input type="text" name="adresse_livraison" id="adresse_livraison" value="{{ old('adresse_livraison') }}" required class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('adresse_livraison')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telephone_contact" class="block text-sm font-medium text-gray-700">Téléphone de contact <span class="text-red-500">*</span></label>
                                    <input type="tel" name="telephone_contact" id="telephone_contact" value="{{ old('telephone_contact') }}" required class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('telephone_contact')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="email_contact" class="block text-sm font-medium text-gray-700">Email de contact <span class="text-red-500">*</span></label>
                                    <input type="email" name="email_contact" id="email_contact" value="{{ old('email_contact', Auth::user()->email) }}" required class="mt-1 focus:ring-amber-500 focus:border-amber-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('email_contact')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Couleurs -->
                        <div class="pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Couleurs du thème</h4>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="couleur_principale" class="block text-sm font-medium text-gray-700">Couleur principale <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <div class="relative flex-grow focus-within:z-10">
                                            <input type="color" name="couleur_principale" id="couleur_principale" value="{{ old('couleur_principale', '#F59E0B') }}" class="h-10 w-full rounded-l-md border-gray-300 focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                        </div>
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                            <span id="couleurPrincipaleValue">{{ old('couleur_principale', '#F59E0B') }}</span>
                                        </span>
                                    </div>
                                    @error('couleur_principale')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="couleur_secondaire" class="block text-sm font-medium text-gray-700">Couleur secondaire <span class="text-red-500">*</span></label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <div class="relative flex-grow focus-within:z-10">
                                            <input type="color" name="couleur_secondaire" id="couleur_secondaire" value="{{ old('couleur_secondaire', '#D97706') }}" class="h-10 w-full rounded-l-md border-gray-300 focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                        </div>
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                            <span id="couleurSecondaireValue">{{ old('couleur_secondaire', '#D97706') }}</span>
                                        </span>
                                    </div>
                                    @error('couleur_secondaire')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <a href="{{ route('liste-mariage.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Annuler
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Créer la liste
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Afficher/masquer le champ de mot de passe en fonction de la case à cocher
    document.addEventListener('DOMContentLoaded', function() {
        const estPubliqueCheckbox = document.getElementById('est_publique');
        const motDePasseContainer = document.getElementById('motDePasseContainer');
        
        function toggleMotDePasseField() {
            if (estPubliqueCheckbox.checked) {
                motDePasseContainer.classList.add('hidden');
            } else {
                motDePasseContainer.classList.remove('hidden');
            }
        }
        
        // Initialiser l'état
        toggleMotDePasseField();
        
        // Écouter les changements
        estPubliqueCheckbox.addEventListener('change', toggleMotDePasseField);
        
        // Mise à jour des valeurs de couleur en temps réel
        const couleurPrincipale = document.getElementById('couleur_principale');
        const couleurSecondaire = document.getElementById('couleur_secondaire');
        const couleurPrincipaleValue = document.getElementById('couleurPrincipaleValue');
        const couleurSecondaireValue = document.getElementById('couleurSecondaireValue');
        
        couleurPrincipale.addEventListener('input', function() {
            couleurPrincipaleValue.textContent = this.value;
        });
        
        couleurSecondaire.addEventListener('input', function() {
            couleurSecondaireValue.textContent = this.value;
        });
    });
</script>
@endpush
