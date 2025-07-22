
<div class="bg-dark text-light py-2 small">
    <div class="container d-flex justify-content-end align-items-center">
        @auth
            <span class="me-3">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                <span class="badge badge-cbm ms-2">{{ ucfirst(Auth::user()->role) }}</span>
            </span>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm me-3 fw-bold"><i class="bi bi-shield-lock"></i> Administration</a>
            @elseif(Auth::user()->role === 'commercant')
                <a href="{{ route('commercant.dashboard') }}" class="btn btn-success btn-sm me-3"><i class="bi bi-shop"></i> Espace Commerçant</a>
            @elseif(Auth::user()->role === 'client')
                <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-sm me-3"><i class="bi bi-person"></i> Espace Client</a>
            @elseif(Auth::user()->role === 'partenaire')
                <a href="{{ route('partenaire.dashboard') }}" class="btn btn-info btn-sm me-3"><i class="bi bi-briefcase"></i> Espace Partenaire</a>
            @endif
            <a href="{{ route('logout') }}" class="text-light"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="text-light me-3"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
            <a href="{{ route('register') }}" class="text-light"><i class="bi bi-person-plus"></i> Inscription</a>
        @endauth
    </div>
</div>
