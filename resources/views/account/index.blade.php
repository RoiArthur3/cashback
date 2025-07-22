@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mon compte</h2>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="list-group">
                <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.dashboard')) active @endif">
                    <i class="bi bi-person-circle me-2"></i> Tableau de bord
                </a>
                <a href="{{ route('account.cashbacks') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.cashbacks')) active @endif">
                    <i class="bi bi-cash-coin me-2"></i> Mes cashbacks
                </a>
                <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.orders')) active @endif">
                    <i class="bi bi-bag-check me-2"></i> Mes achats
                </a>
                <a href="{{ route('account.settings') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.settings')) active @endif">
                    <i class="bi bi-gear me-2"></i> Paramètres
                </a>
                @if(Auth::user()->hasRole(['commercant','partenaire']))
                <a href="{{ route('account.boutique') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.boutique')) active @endif">
                    <i class="bi bi-shop me-2"></i> Ma boutique
                </a>
                @endif
                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-shield-lock me-2"></i> Administration
                </a>
                @endif
            </div>
        </div>
        <div class="col-md-9">
            @yield('account-content')
        </div>
    </div>
</div>
@endsection
