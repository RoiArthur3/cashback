@extends('admin_layout.admin')
@section('title','Détail commande #'.$commande->id)

@section('content')
<div class="pc-container"><div class="pc-content">
  <h4 class="mb-3">Commande #{{ $commande->id }}</h4>

  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div><strong>Boutique :</strong> {{ optional($commande->boutique)->nommagasin }}</div>
          <div><strong>Produit :</strong> {{ optional($commande->produit)->nomproduit }}</div>
          <div><strong>Quantité :</strong> {{ $commande->qty }}</div>
        </div>
        <div class="col-md-6 text-md-end">
          <div><strong>Total :</strong> {{ number_format($commande->total_fcfa,0,',',' ') }} FCFA</div>
          <div><strong>Cashback total :</strong> {{ number_format($commande->cashback_fcfa,0,',',' ') }} FCFA</div>
          <div><strong>Statut :</strong>
            @switch($commande->status)
              @case('paid')    <span class="badge bg-success">Payée</span>@break
              @case('pending') <span class="badge bg-warning text-dark">En attente</span>@break
              @case('failed')  <span class="badge bg-danger">Échouée</span>@break
              @default         <span class="badge bg-secondary">{{ $commande->status }}</span>
            @endswitch
          </div>
        </div>
      </div>
    </div>
  </div>

  @if($commande->status === 'pending')
    <div class="card shadow-sm">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>Procéder au paiement :</div>
        <form action="{{ route('client.orders.pay',$commande->id) }}" method="POST" class="d-flex gap-2">
          @csrf
          <select name="channel" class="form-select">
            <option value="">Choisir sur le portail</option>
            <option value="CARD">Carte</option>
            <option value="OMCIV2">Orange Money CI</option>
            <option value="MOMO">MTN MoMo</option>
            <option value="FLOOZ">Moov Flooz</option>
            <option value="WAVE">WAVE</option>
          </select>
          <button class="btn btn-primary">Payer</button>
        </form>
      </div>
    </div>
  @endif

</div></div>
@endsection
