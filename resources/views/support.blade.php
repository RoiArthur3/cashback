@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Assistance & Support</h2>
    <div class="alert alert-info">Bienvenue sur la page d'assistance. Pour toute question ou problème, contactez-nous via le formulaire ci-dessous ou consultez la FAQ.</div>
    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Votre email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Votre message</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>
@endsection
