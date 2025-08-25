@extends('admin_layout.admin')
@section('title','Commandes — Mes boutiques')

@section('content')
<div class="pc-container"><div class="pc-content">
  <h4 class="mb-3">Commandes (mes boutiques)</h4>

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
          <a class="btn btn-light" href="{{ route('commercial.orders') }}">Réinitialiser</a>
        </div>
      @endif
    </form>
  @endif

  <div class="row g-3 mb-3">
    <div class="col-md-3">
      <div class="card shadow-sm"><div class="card-body">
        <div class="text-muted">Total payé</div>
        <div class="h4 mb-0">{{ number_format($paidSum,0,',',' ') }} FCFA</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm"><div class="card-body">
        <div class="text-muted">Total en attente</div>
        <div class="h4 mb-0">{{ number_format($pendingSum,0,',',' ') }} FCFA</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm"><div class="card-body">
        <div class="text-muted">Commandes payées</div>
        <div class="h4 mb-0">{{ number_format($countPaid,0,',',' ') }}</div>
      </div></div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm"><div class="card-body">
        <div class="text-muted">Commandes en attente</div>
        <div class="h4 mb-0">{{ number_format($countPending,0,',',' ') }}</div>
      </div></div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header">Liste des commandes</div>
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Date</th>
            <th>Client</th>
            <th>Produit</th>
            <th class="text-end">Qté</th>
            <th class="text-end">Total</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
        @forelse($orders as $o)
          <tr>
            <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ optional($o->user)->name }}</td>
            <td>{{ optional($o->produit)->nomproduit }}</td>
            <td class="text-end">{{ $o->qty }}</td>
            <td class="text-end">{{ number_format($o->total_fcfa,0,',',' ') }} FCFA</td>
            <td>
              @switch($o->status)
                @case('paid')    <span class="badge bg-success">Payée</span>@break
                @case('pending') <span class="badge bg-warning text-dark">En attente</span>@break
                @case('failed')  <span class="badge bg-danger">Échouée</span>@break
                @default         <span class="badge bg-secondary">{{ $o->status }}</span>
              @endswitch
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-4">Aucune commande pour l’instant.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $orders->links() }}</div>
  </div>
</div></div>
@endsection
