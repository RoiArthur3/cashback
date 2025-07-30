@extends('layouts.app')

@section('title', 'Liste de Mariage')

@section('content')
<!-- Hero section -->
<div class="hero position-relative mb-4" style="height: 180px; background: url('{{ $mariage->image_url }}') center/cover;">
    <div class="hero-overlay d-flex flex-column justify-content-end p-3" style="background: rgba(0,0,0,0.4); height: 100%;">
        <h2 class="text-white fw-bold mb-1">{{ $mariage->titre }}</h2>
        <span class="text-white-50">{{ $mariage->date->format('d F Y') }}</span>
    </div>
</div>

<!-- Stats -->
<div class="d-flex justify-content-around mb-3">
    <div class="text-center">
        <span class="fw-bold fs-4 text-primary">{{ $stats['articles'] }}</span>
        <div class="small text-muted">Articles</div>
    </div>
    <div class="text-center">
        <span class="fw-bold fs-4 text-success">{{ $stats['reserves'] }}</span>
        <div class="small text-muted">Réservés</div>
    </div>
    <div class="text-center">
        <span class="fw-bold fs-4 text-info">{{ $stats['disponibles'] }}</span>
        <div class="small text-muted">Disponibles</div>
    </div>
</div>

<!-- Articles -->
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Articles</h4>
    <button class="btn btn-primary" id="ajouterArticleBtn">+ Ajouter</button>
</div>
<div id="articlesList">
    @foreach($articles as $article)
        <div class="card mb-2">
            <div class="card-body d-flex align-items-center">
                <img src="{{ $article->image_url }}" alt="" class="me-3" style="width:60px; height:60px; object-fit:cover;">
                <div class="flex-grow-1">
                    <div class="fw-bold">{{ $article->nom }}</div>
                    <div class="small text-muted">{{ $article->boutique }}</div>
                    <div class="fw-bold text-dark">{{ number_format($article->prix, 0, ',', ' ') }} FCFA</div>
                    <div class="text-success small">{{ number_format($article->cashback, 0, ',', ' ') }} FCFA cashback</div>
                </div>
                <div>
                    @if($article->disponible)
                        <span class="badge bg-success mb-2">Disponible</span>
                        <button class="btn btn-outline-primary btn-sm" onclick="reserverArticle({{ $article->id }})">Réserver</button>
                    @else
                        <span class="badge bg-danger mb-2">Réservé</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- AJAX scripts (exemple) -->
<script>
function reserverArticle(id) {
    fetch('/mariage/article/reserver/' + id, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    })
    .then(response => response.json())
    .then(data => {
        // Rafraîchir la liste ou afficher un message
        location.reload();
    });
}
document.getElementById('ajouterArticleBtn').onclick = function() {
    // Ouvrir un modal AJAX pour ajouter un article
};
</script>
@endsection
