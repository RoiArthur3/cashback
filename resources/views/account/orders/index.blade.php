@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mes commandes</h2>
    @if($orders->isEmpty())
        <div class="alert alert-info">Aucune commande trouvée.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ number_format($order->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $order->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
