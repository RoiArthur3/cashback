@props(['campagne'])
<div class="card mb-3 shadow-sm">
    @if($campagne->media)
        <img src="{{ Storage::url($campagne->media) }}" class="card-img-top" alt="Visuel campagne">
    @endif
    <div class="card-body">
        <h5 class="card-title">{{ $campagne->titre }}</h5>
        <p class="card-text">{{ $campagne->texte_accroche }}</p>
        <a href="{{ $campagne->lien }}" class="btn btn-primary" target="_blank">Découvrir</a>
    </div>
</div>
