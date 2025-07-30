
@extends('layouts.app')
@section('title', 'KDO Surprise')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-gradient-to-r from-pink-600 to-pink-400 text-white rounded-top-4">
                    <h2 class="mb-0 fw-bold">🎁 Offrir un KDO surprise</h2>
                </div>
                <div class="card-body">
                    <form id="kdo-form">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sélectionnez 1 à 3 produits surprise</label>
                            <div class="row">
                                @foreach($produits as $produit)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <img src="{{ $produit->image_url }}" class="card-img-top" alt="{{ $produit->nom }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $produit->nom }}</h5>
                                            <p class="card-text text-muted">{{ $produit->boutique->nom }}</p>
                                            <p class="card-text fw-bold text-pink">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="produits[]" value="{{ $produit->id }}" id="produit{{ $produit->id }}">
                                                <label class="form-check-label" for="produit{{ $produit->id }}">Choisir</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-text">Vous pouvez laisser CBM choisir aléatoirement si vous ne sélectionnez rien.</div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="recipient_name" class="form-label">Nom complet du destinataire</label>
                            <input type="text" class="form-control" id="recipient_name" name="recipient_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient_contact" class="form-label">Téléphone ou email</label>
                            <input type="text" class="form-control" id="recipient_contact" name="recipient_contact" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse de livraison</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message personnalisé <span class="text-muted">(facultatif)</span></label>
                            <textarea class="form-control" id="message" name="message" rows="2"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="anonymous" name="anonymous">
                            <label class="form-check-label" for="anonymous">Rester anonyme (le bénéficiaire ne saura pas qui a offert)</label>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Paiement</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="1" placeholder="Montant total à régler (frais inclus)" required>
                            <div class="form-text">Le cashback sera appliqué comme sur tout achat normal.</div>
                        </div>
                        <button type="submit" class="btn btn-pink w-100 fw-bold">Envoyer le KDO surprise</button>
                    </form>
                    <div id="kdo-success" class="alert alert-success d-none mt-3">KDO envoyé avec succès ! Le bénéficiaire recevra une surprise sans connaître le produit à l'avance.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('kdo-form').addEventListener('submit', function(e) {
    e.preventDefault();
    // Simuler l'envoi AJAX
    document.getElementById('kdo-success').classList.remove('d-none');
    setTimeout(function(){
        document.getElementById('kdo-success').classList.add('d-none');
    }, 3000);
});
</script>
@endsection
