@extends('admin_layout.admin')
@section('title','Transactions Cashback')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <h4 class="mb-3">
            Transactions Cashback
            @if($currentBoutique)
                — <span class="text-muted">{{ $currentBoutique->nommagasin }}</span>
            @endif
        </h4>

        <form method="GET" class="row g-1 mb-3">
            <div class="col-md-6">
                <select name="boutique_id" class="form-select" onchange="this.form.submit()">
                <option value="">Toutes les boutiques</option>
                @foreach($boutiques as $b)
                    <option value="{{ $b->id }}" @selected($boutiqueId == $b->id)>
                    {{ $b->nommagasin }}
                    </option>
                @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary">Filtrer</button>
            </div>
            @if($boutiqueId)
                <div class="col-md-2 d-grid">
                <a href="{{ route('cashback.transactions') }}" class="btn btn-light">Réinitialiser</a>
                </div>
            @endif
        </form>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted">Total cashback payé aux utilisateurs</div>
                        <div class="h4 mb-0">{{ number_format($totalCashbackPaye, 0, ',', ' ') }} FCFA</div>
                    </div>
                </div>
            </div>

            {{-- Petit récap par rôle (global) --}}
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted mb-2">Répartition globale (contrôle)</div>
                        <div class="d-flex flex-wrap gap-3">
                            <span class="badge bg-primary">Clients :
                            {{ number_format($byRole['client'] ?? 0, 0, ',', ' ') }} FCFA
                            </span>
                            <span class="badge bg-success">Commerciaux :
                            {{ number_format($byRole['commercial'] ?? 0, 0, ',', ' ') }} FCFA
                            </span>
                            <span class="badge bg-info text-dark">Parrains :
                            {{ number_format($byRole['parrain'] ?? 0, 0, ',', ' ') }} FCFA
                            </span>
                            <span class="badge bg-secondary">CBM :
                            {{ number_format($byRole['cbm'] ?? 0, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card table-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover tbl-product" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Utilisateur</th>
                                        <th class="text-end">Montant</th>
                                        <th>Commande</th>
                                        <th>Boutique</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tx as $t)
                                    <tr>
                                        <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                        {{ optional($t->wallet->user)->name }}
                                        <div class="small text-muted">{{ optional($t->wallet->user)->email }}</div>
                                        </td>
                                        <td class="text-end text-success">+ {{ number_format($t->amount_fcfa,0,',',' ') }} FCFA</td>
                                        <td>#{{ $t->commande_id }}</td>
                                        <td>{{ optional(optional($t->commande)->boutique)->nommagasin }}</td>
                                        <td>{{ $t->description }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune transaction de cashback.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="{{asset('backend/dist/assets/js/plugins/simple-datatables.js')}}"></script>
<script>
  const dataTable = new simpleDatatables.DataTable('#pc-dt-simple', {
    sortable: false,
    perPage: 5
  });
</script>

@endsection
