<div class="bg-dark text-light py-2 small">
    <div class="container d-flex justify-content-end align-items-center gap-4">
        @auth
            <a href="/{{ Auth::id() }}/dashboard_{{ Auth::id() }}" class="userbar-link d-flex align-items-center gap-1">
                <i class="bi bi-person-fill"></i> Mon espace
            </a>
            <a href="#" class="userbar-link d-flex align-items-center gap-1">
                <i class="bi bi-chat-dots"></i> Messages
            </a>
            <a href="#" class="userbar-link d-flex align-items-center gap-1">
                <i class="bi bi-bell"></i> Notifications
            </a>
            <span class="text-muted">|</span>
            <a href="{{ route('logout') }}" class="userbar-link d-flex align-items-center gap-1"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="userbar-link d-flex align-items-center gap-1">
                <i class="bi bi-box-arrow-in-right"></i> Connexion
            </a>
            <a href="{{ route('register') }}" class="userbar-link d-flex align-items-center gap-1">
                <i class="bi bi-person-plus"></i> Inscription
            </a>
        @endauth
    </div>
</div>
