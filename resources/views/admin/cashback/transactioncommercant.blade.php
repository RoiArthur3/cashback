@extends('admin_layout.admin')
@section('title','Transactions Cashback — Mes boutiques')

@section('content')
<div class="pc-container"><div class="pc-content">
  <h4 class="mb-3">Transactions de cashback (mes boutiques)</h4>

  {{-- Filtre par boutique (si plusieurs) --}}
  @if($boutiques->count() > 1)
    <form method="GET" class="row g-2 mb-3">
      <div class="col-md-6">
        <select name="boutique_id" class="form-select" onchange="this.form.submit()">
          <option value="">Toutes mes boutiques</option>
          @foreach($boutiques as $b)
            <option value="{{ $b->id }}" @selected($boutiqueId == $b->id)>{{ $b->nommagasin }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-grid">
        <button class="btn btn-primary">Filtrer</button>
      </div>
      @if($boutiqueId)
        <div class="col-md-2 d-grid">
          <a class="btn btn-light" href="{{ route('commercial.transactions') }}">Réinitialiser</a>
        </div>
      @endif
    </form>
  @endif

  <div class="row g-3">
    <div class="col-md-4">
      <div class="card shadow-sm"><div class="card-body">
        <div class="text-muted">Total cashback versé (toutes parts)</div>
        <div class="h4 mb-0">{{ number_format($sum,0,',',' ') }} FCFA</div>
      </div></div>
    </div>
    <div class="col-md-8">
      <div class="card shadow-sm"><div class="card-body">
        <div class="text-muted mb-2">Répartition (sur mes boutiques)</div>
        <div class="d-flex flex-wrap gap-3">
          <span class="badge bg-primary">Clients :
            {{ number_format($byRole['client'] ?? 0, 0, ',', ' ') }} FCFA
          </span>
          <span class="badge bg-success">Commercial (moi) :
            {{ number_format($byRole['commercial'] ?? 0, 0, ',', ' ') }} FCFA
          </span>
          <span class="badge bg-info text-dark">Parrains :
            {{ number_format($byRole['parrain'] ?? 0, 0, ',', ' ') }} FCFA
          </span>
          <span class="badge bg-secondary">CBM :
            {{ number_format($byRole['cbm'] ?? 0, 0, ',', ' ') }} FCFA
          </span>
        </div>
      </div></div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header">Transactions</div>
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Date</th>
            <th>Bénéficiaire</th>
            <th class="text-end">Montant</th>
            <th>Rôle</th>
            <th>Commande</th>
            <th>Boutique</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
        @forelse($tx as $t)
          @php
            // récupérer le rôle via la description si besoin, sinon laisser vide
            $desc = $t->description ?? '';
            $role = str_contains($desc,'Commercial') ? 'commercial'
                  : (str_contains($desc,'Parrain') ? 'parrain'
                  : (str_contains($desc,'acheteur') ? 'client' : ''));
          @endphp
          <tr>
            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
            <td>
              {{ optional($t->wallet->user)->name }}
              <div class="small text-muted">{{ optional($t->wallet->user)->email }}</div>
            </td>
            <td class="text-end text-success">+ {{ number_format($t->amount_fcfa,0,',',' ') }} FCFA</td>
            <td class="text-uppercase">{{ $role }}</td>
            <td>#{{ $t->commande_id }}</td>
            <td>{{ optional(optional($t->commande)->boutique)->nommagasin }}</td>
            <td>{{ $desc }}</td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted py-4">Aucune transaction trouvée.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $tx->links() }}</div>
  </div>
</div></div>
@endsection
