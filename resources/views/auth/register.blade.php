{{--
@extends('layouts.app')

@section('content')
<style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .register-fullpage {
        min-height: 100vh;
        width: 100vw;
        display: flex;
        align-items: stretch;
        background: #f8fafc;
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .register-pub {
        background: linear-gradient(135deg, #2563eb 60%, #facc15 100%);
        min-width: 0;
        flex: 1 1 0%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0;
    }
    .register-form {
        background: #fff;
        flex: 1 1 0%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2.5rem 1.5rem;
        min-width: 0;
    }
    @media (max-width: 991.98px) {
        .register-fullpage {
            flex-direction: column;
        }
        .register-pub {
            min-height: 180px;
            flex: none;
            padding: 2rem 1rem 1rem 1rem;
        }
        .register-form {
            min-height: 60vh;
        }
    }
</style>
<div class="register-fullpage">
    <!-- Colonne publicité -->
    <div class="register-pub">
        <img src="{{ asset('images/pub-cbm.png') }}" alt="Publicité" class="img-fluid mb-4 rounded-3 shadow" style="max-height: 180px; background: #fff;">
        <h2 class="text-white fw-bold mb-3 text-center" style="text-shadow: 0 2px 8px #0002;">Profitez du cashback sur tous vos achats !</h2>
        <p class="text-white-50 text-center mb-0">Inscrivez-vous et recevez un bonus de bienvenue.<br>Découvrez nos partenaires et économisez chaque jour.</p>
    </div>
    <!-- Formulaire d'inscription -->
    <div class="register-form">
        <div class="mb-4 text-center">
            <img src="{{ asset('logo-cashback-market.png') }}" alt="Cashback Market" style="height: 60px;">
        </div>
        <h1 class="mb-2 fw-bold text-primary text-center" style="font-size:2.2rem;">Créer un compte acheteur</h1>
        <p class="mb-4 text-center text-secondary">Rejoignez la communauté Cashback Market et commencez à économiser dès aujourd'hui !</p>
        <form method="POST" action="{{ route('register') }}" class="w-100" style="max-width: 480px; margin: 0 auto;">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nom complet</label>
                <input id="name" type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Adresse e-mail</label>
                <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Mot de passe</label>
                <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password-confirm" class="form-label fw-semibold">Confirmer le mot de passe</label>
                <input id="password-confirm" type="password" class="form-control rounded-3" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label fw-semibold">Type de compte</label>
                <select id="role" name="role" class="form-select rounded-3" required>
                    <option value="acheteur" selected>Acheteur</option>
                    <option value="client">Client</option>
                    <option value="commercant">Commerçant</option>
                    <option value="annonceur">Annonceur</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm" style="background: linear-gradient(90deg, #2563eb 80%, #facc15 100%); border: none; font-size: 1.1rem;">Créer mon compte</button>
        </form>
        <div class="mt-4 text-center">
            <span class="text-secondary">Déjà inscrit ?</span>
            <a href="{{ route('login') }}" class="text-primary fw-semibold ms-2">Se connecter</a>
        </div>
    </div>
</div>
@endsection
 --}}

@php use Illuminate\Support\Facades\Route; @endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Cashback Market</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .bg-auth {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        .btn-primary {
            background-color: #2563eb;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left side - Image/Illustration -->
        <div class="bg-auth hidden md:flex md:w-1/2 p-12 text-white">
            <div class="max-w-md m-auto">
                <h1 class="text-4xl font-bold mb-6">Bienvenue sur Cashback Market</h1>
                <p class="text-xl mb-8">Inscrivez-vous pour accéder à votre espace personnel et profiter de vos avantages cashback.</p>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                            <i class="fas fa-piggy-bank text-white text-xl"></i>
                        </div>
                        <span>Jusqu'à 15% de cashback</span>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                            <i class="fas fa-tag text-white text-xl"></i>
                        </div>
                        <span>Des centaines de boutiques partenaires</span>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <span>Paiement sécurisé</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Login Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <a href="{{ url('/') }}" class="inline-block">
                        <span class="text-3xl font-bold text-blue-600">Cashback<span class="text-blue-400">Market</span></span>
                    </a>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Inscrivez-vous
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Ou
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Connectez-vous
                        </a>
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                    @csrf
                    <div class="rounded-md shadow-sm space-y-4">

                          <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <div class="mt-1">
                                <input id="name" name="name" type="text" autocomplete="email" required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror"
                                       value="{{ old('name') }}" autofocus>
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror"
                                       value="{{ old('email') }}" autofocus>
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Mot de passe</label>
                            <input id="password" type="password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm form-control rounded-3 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label fw-semibold">Confirmer le mot de passe</label>
                            <input id="password-confirm" type="password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm form-control rounded-3" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div>
                            <label for="role" class="form-label fw-semibold">Type de compte</label>
                            <select id="role" name="role" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-500 @enderror" required>
                                <option value="acheteur" selected>Acheteur</option>
                                <option value="client">Client</option>
                                <option value="commercant">Commerçant</option>
                                <option value="annonceur">Annonceur</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            S'inscrire
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou continuez avec</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div>
                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Se connecter avec Google</span>
                                <i class="fab fa-google text-red-500"></i>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Se connecter avec Facebook</span>
                                <i class="fab fa-facebook text-blue-600"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- <div class="mt-8 text-center text-sm text-gray-600">
                    <p>Vous n'avez pas encore de compte ?</p>
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Créer un compte
                    </a>
                </div> --}}
            </div>
        </div>
    </div>
</body>
</html>
