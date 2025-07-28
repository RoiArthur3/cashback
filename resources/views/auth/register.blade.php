
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
