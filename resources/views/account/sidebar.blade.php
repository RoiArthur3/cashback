<div class="list-group">
    <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.dashboard')) active @endif">
        <i class="bi bi-person-circle me-2"></i> Tableau de bord
    </a>
    <a href="{{ route('account.cashbacks') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.cashbacks')) active @endif">
        <i class="bi bi-cash-coin me-2"></i> Mes cashbacks
    </a>
    <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.orders')) active @endif">
        <i class="bi bi-bag-check me-2"></i> Mes commandes
    </a>
    <a href="{{ route('account.wedding-lists') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.wedding-lists')) active @endif">
        <i class="bi bi-heart me-2"></i> Mes listes de mariage
    </a>
    <a href="{{ route('account.troc') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.troc')) active @endif">
        <i class="bi bi-arrow-left-right me-2"></i> Proposer un troc
    </a>
    <a href="{{ route('account.circles') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.circles')) active @endif">
        <i class="bi bi-people me-2"></i> Mes cercles
    </a>
    <a href="{{ route('account.messages') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.messages')) active @endif">
        <i class="bi bi-chat-dots me-2"></i> Messagerie
        @if(true) {{-- Condition pour les messages non lus --}}
            <span class="badge bg-danger ms-auto">3</span>
        @endif
    </a>
    <a href="{{ route('account.settings') }}" class="list-group-item list-group-item-action @if(request()->routeIs('account.settings')) active @endif">
        <i class="bi bi-gear me-2"></i> Paramètres
    </a>
    @if(Auth::user()->hasAnyRole(['commercant','partenaire']))
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
