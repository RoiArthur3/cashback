<li class="dropdown pc-h-item header-user-profile">
    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
        @if (auth()->user()->image)
            <img src="{{ Storage::disk('s3')->url(auth()->user()->image) }}" alt="user-image" style="height:42px" class="user-avtar" />
        @else
            <img src="{{asset('backend/dist/assets/images/user/avatar-1.jpg')}}" alt="user-image" class="user-avtar" />
        @endif
    </a>
    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
        <h5 class="m-0">Profil</h5>
        </div>
        <div class="dropdown-body">
        <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
            <ul class="list-group list-group-flush w-100">
            <li class="list-group-item">
                <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    @if (auth()->user()->image)
                        <img src="{{ Storage::disk('s3')->url(auth()->user()->image) }}" alt="user-image" style="height:50px" class="wid-50 rounded-circle" />
                    @else
                        <img src="{{asset('backend/dist/assets/images/user/avatar-1.jpg')}}" alt="user-image" class="wid-50 rounded-circle" />
                    @endif
                </div>
                <div class="flex-grow-1 mx-3">
                    <h5 class="mb-0">{{auth()->user()->username}}</h5>
                    <a class="link-primary" href="mailto:carson.darrin@company.io">{{auth()->user()->email}}</a>
                </div>
                </div>
            </li>

            <li class="list-group-item">

                <div class="dropdown-item">
                <span class="d-flex align-items-center">
                    <i class="ph-duotone ph-moon"></i>
                    <span>Mode sombre</span>
                </span>
                <div class="form-check form-switch form-check-reverse m-0">
                    <input class="form-check-input f-18" id="dark-mode" type="checkbox" onclick="dark_mode()"
                    role="switch" />
                </div>
                </div>
            </li>
            <li class="list-group-item">
                <a href="{{route('moncompte')}}" class="dropdown-item">
                <span class="d-flex align-items-center">
                    <i class="ph-duotone ph-user"></i>
                    <span>Mon compte</span>
                </span>
                </a>
            </li>


            <li class="list-group-item">

                <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                <span class="d-flex align-items-center">
                    <i class="ph-duotone ph-power"></i>
                    <span>Déconnexion</span>
                </span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            </ul>
        </div>
        </div>
    </div>
    </li>
