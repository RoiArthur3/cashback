<div class="card mb-4">
    <div class="card-header bg-light fw-bold">Avis des clients</div>
    <div class="card-body">
        @if($boutique->avis->count())
            <div class="mb-3">
                @foreach($boutique->avis as $avis)
                    <div class="mb-2 border-bottom pb-2">
                        <div class="d-flex align-items-center mb-1">
                            <span class="fw-bold me-2">{{ $avis->user->name ?? 'Client' }}</span>
                            <span class="text-warning">
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= $avis->note ? '-fill' : '' }}"></i>
                                @endfor
                            </span>
                            <span class="text-muted small ms-2">{{ $avis->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div>{{ $avis->commentaire }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info mb-0">Aucun avis pour cette boutique.</div>
        @endif
        <hr>
        <form action="{{ route('boutique.avis.store', $boutique->id) }}" method="POST">
            @csrf
            <div class="mb-2">
                <label for="note" class="form-label">Votre note :</label>
                <select name="note" id="note" class="form-select w-auto d-inline-block ms-2">
                    @for($i=5; $i>=1; $i--)
                        <option value="{{ $i }}">{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>
            <div class="mb-2">
                <label for="commentaire" class="form-label">Votre avis :</label>
                <textarea name="commentaire" id="commentaire" class="form-control" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn btn-cbm">Laisser un avis</button>
        </form>
    </div>
</div>
