<nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        @if (auth()->user()->role_id === 1)
            <a href="{{route('dashboard.admin')}}" class="b-brand text-primary"></a>
        @elseif (auth()->user()->role_id === 2)
            <a href="{{route('dashboard.client')}}" class="b-brand text-primary"></a>
        @elseif (auth()->user()->role_id === 3)
            <a href="{{route('dashboard.commercant')}}" class="b-brand text-primary"></a>
        {{-- @elseif (auth()->user()->role_id === 4)
            <a href="{{route('dashboard.rh')}}" class="b-brand text-primary"></a>
        @elseif (auth()->user()->role_id === 5)
            <a href="{{route('dashboard.comptable')}}" class="b-brand text-primary"></a>
        @elseif (auth()->user()->role_id === 6)
            <a href="{{route('dashboard.commercial')}}" class="b-brand text-primary"></a>
        @elseif (auth()->user()->role_id === 7)
            <a href="{{route('dashboard.community-manager')}}" class="b-brand text-primary"></a> --}}
        @endif
        <!-- ========   Change your logo from here   ============ -->
       @if (auth()->user()->role_id != 1)
        @if (auth()->user()->boutique && auth()->user()->boutique->image)
            <img src="{{ asset('storage/' . auth()->user()->boutique->image) }}" width="56" height="56" alt="Logo" style="border-radius: 45%;" />
        @else
            <!-- Optionnel : Afficher une image par défaut si l'image du magasin n'est pas disponible -->
            <img src="{{ asset('path/to/default-image.png') }}" width="56" height="56" alt="Default Profile Image" />
        @endif

        @else
            <a href="/">
                <img src="{{ asset('logo.jpg') }}" height="60" alt="logo image" />
                <span style="color: #71709b; font-weight:bold;">CashBack</span>
            </a>
        @endif

        @if (auth()->user()->role_id == 3 || auth()->user()->role_id == 4
            || auth()->user()->role_id == 5 || auth()->user()->role_id == 6 || auth()->user()->role_id == 7)
            @if (auth()->user()->boutique && auth()->user()->boutique->slug)
                <a href="{{ route('laboutique', auth()->user()->boutique->slug) }}">
                    <span class="badge bg-primary rounded-pill ms-2 pc-mtext theme-version">Voir la boutique</span>
                </a>
            @else
                <!-- Optionnel : Afficher un message ou un lien alternatif si le slug du magasin n'est pas disponible -->
                <span class="badge bg-primary rounded-pill ms-2 theme-version">Aucune boutique</span>
            @endif
        @endif


      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          <li class="pc-item pc-hasmenu">
            @if (auth()->user()->role_id == 1)
                <a href="{{route('dashboard.admin')}}" class="pc-link">
            @elseif (auth()->user()->role_id == 2)
                <a href="{{route('dashboard.client')}}" class="pc-link">
            @elseif (auth()->user()->role_id == 3)
                <a href="{{route('dashboard.commercant')}}" class="pc-link">
            {{-- @elseif (auth()->user()->role_id == 2)
                <a href="{{route('dashboard.admin')}}" class="pc-link">
            @elseif (auth()->user()->role_id == 4)
                <a href="{{route('dashboard.rh')}}" class="pc-link">
            @elseif (auth()->user()->role_id == 5)
                <a href="{{route('dashboard.comptable')}}" class="pc-link">
            @elseif (auth()->user()->role_id == 6)
                <a href="{{route('dashboard.commercial')}}" class="pc-link">
            @elseif (auth()->user()->role_id == 7)
                <a href="{{route('dashboard.community-manager')}}" class="pc-link"> --}}
            @endif
              <span class="pc-micon">
                <i class="ph-duotone ph-gauge"></i>
              </span>
              <span class="pc-mtext">Tableau de bord</span>
            </a>
          </li>

          @if(auth()->user()->role_id === 3 && auth()->user()->boutique===null)
          <li class="pc-item pc-hasmenu">
            <a href="{{route('boutique.create')}}" class="pc-link">
              <span class="pc-micon">
                <i class="ph-duotone ph-codesandbox-logo"></i>
              </span>
              <span class="pc-mtext">Créer une boutique</span><span class="pc-arrow"></span
            ></a>
          </li>
          @endif

          @if(auth()->user()->role_id === 2)

          <li class="pc-item pc-hasmenu">
            <a href="{{route('listecommandeclients')}}" class="pc-link">
                <span class="pc-micon">
                    <i class="ph-duotone ph-identification-card"></i>
                </span>
              <span class="pc-mtext">Mes commandes</span><span class="pc-arrow"></span
            ></a>
          </li>
          @endif

          @if(auth()->user()->role_id === 1)

          <li class="pc-item pc-hasmenu">
            <a href="{{route('listeuser.admin')}}" class="pc-link">
                <span class="pc-micon">
                    <i class="ph-duotone ph-identification-card"></i>
                </span>
              <span class="pc-mtext">Utilisateurs</span><span class="pc-arrow"></span
            ></a>
          </li>
          @endif


          @if(auth()->user()->role_id === 3 && auth()->user()->boutique)
          <li class="pc-item pc-hasmenu">
            <a href="{{route('categorie.index')}}" class="pc-link">
              <span class="pc-micon">
                <i class="ph-duotone ph-codesandbox-logo"></i>
              </span>
              <span class="pc-mtext">Catégories</span><span class="pc-arrow"></span
            ></a>
          </li>


          <li class="pc-item pc-hasmenu">
            <a href="{{route('produit.index')}}" class="pc-link">

                <span class="pc-micon">
                    <i class="ph-duotone ph-handbag"></i>
                </span>
                <span class="pc-mtext">Produits</span><span class="pc-arrow"></span>
            </a>
          </li>
          @endif

          @if(auth()->user()->role_id === 1)

          <li class="pc-item pc-hasmenu">
            <a href="{{ route('role.index') }}" class="pc-link">
              <span class="pc-micon">
                <i class="ph-duotone ph-shopping-cart"></i>
              </span>
              <span class="pc-mtext">Roles</span><span class="pc-arrow"></span>
            </a>
          </li>

          <li class="pc-item pc-hasmenu">
            <a href="{{route('listmagasin.admin')}}" class="pc-link">
              <span class="pc-micon">
                <i class="ph-duotone ph-shopping-bag"></i>
              </span>
              <span class="pc-mtext">Boutiques</span><span class="pc-arrow"></span>
            </a>
          </li>

          <li class="pc-item pc-hasmenu">
            <a href="{{route('typeboutique.index')}}" class="pc-link">
              <span class="pc-micon">
                <i class="ph-duotone ph-flower-lotus"></i>
              </span>
              <span class="pc-mtext">Types Boutiques</span><span class="pc-arrow"></span>
            </a>
          </li>
          @elseif(auth()->user()->role_id === 3 && auth()->user()->boutique)
            <li class="pc-item pc-hasmenu">
                <a href="{{ route('black_friday.index') }}" class="pc-link">
                    <span class="pc-micon">
                        <i class="ph-duotone ph-coins"></i>
                    </span>
                    <span class="pc-mtext">Promos</span>
                    <span class="pc-arrow"></span>
                </a>
            </li>

            {{-- <li class="pc-item pc-hasmenu {{ request()->routeIs('partenaire.*','noclients.*') ? 'active pc-trigger' : '' }}">
                <a href="#!" class="pc-link">
                  <span class="pc-micon">
                    <i class="ph-duotone ph-image"></i>
                  </span>
                  <span class="pc-mtext">Bannières</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                ></a>
                <ul class="pc-submenu">
                    <li class="pc-item {{ request()->routeIs('partenaire.*') ? 'active' : '' }}"><a class="pc-link" href="{{route('partenaire.index')}}">Partenaires</a></li>
                    <li class="pc-item {{ request()->routeIs('noclients.*') ? 'active' : '' }}"><a class="pc-link" href="{{route('noclients.index')}}">Clients</a></li>
                </ul>
            </li> --}}
         @endif

         @if (auth()->user()->role_id === 7)
             <li class="pc-item pc-hasmenu {{ request()->routeIs('communitymanagerblack_friday.*') ? 'active pc-trigger' : '' }}">
                <a href="{{ route('communitymanagerblack_friday.index') }}" class="pc-link">
                    <span class="pc-micon">
                        <i class="ph-duotone ph-coins"></i>
                    </span>
                    <span class="pc-mtext">Promos</span>
                    <span class="pc-arrow"></span>
                </a>
            </li>
         @endif



        @if (auth()->user()->role_id === 3 && auth()->user()->boutique)
            <li class="pc-item pc-hasmenu {{ request()->routeIs('createuser.*','edituser.*') ? 'active pc-trigger' : '' }}">
                <a href="#!" class="pc-link">
                <span class="pc-micon">
                    <i class="ph-duotone ph-gear-six"></i>
                </span>
                <span class="pc-mtext">Paramètres</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                ></a>
                <ul class="pc-submenu">
                {{-- <li class="pc-item {{ request()->routeIs('succursale.*') ? 'active pc-trigger' : '' }}"><a class="pc-link" href="{{ route('succursale.index') }}">Succursales</a></li> --}}
                <li class="pc-item {{ request()->routeIs('createuser.*','edituser.*') ? 'active pc-trigger' : '' }}"><a class="pc-link" href="{{ route('listeuser.admin') }}">Utilisateurs</a></li>
                <li class="pc-item"><a class="pc-link" href="{{ route('boutique.edit', ['id' => auth()->user()->boutique->id]) }}">Ma boutique</a></li>
                </ul>
            </li>
        @endif


        @if (auth()->user()->role_id === 4)
            <li class="pc-item pc-hasmenu ">
                <a href="#!" class="pc-link">
                <span class="pc-micon">
                    <i class="ph-duotone ph-gear-six"></i>
                </span>
                <span class="pc-mtext">Paramètres</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                ></a>
                <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="{{ route('rhsuccursale.index') }}">Succursales</a></li>
                <li class="pc-item"><a class="pc-link" href="{{ route('listeuser.admin') }}">Utilisateurs</a></li>
                <li class="pc-item"><a class="pc-link" href="{{ route('boutique.edit', ['id' => auth()->user()->magasin->id]) }}">Ma boutique</a></li>
                </ul>
            </li>
        @endif



        </ul>

      </div>
      <div class="card pc-user-card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                @if (auth()->user()->image)
                    <img src="{{ Storage::disk('s3')->url(auth()->user()->image) }}" style="height:45px" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                @else
                    <img src="{{asset('backend/dist/assets/images/user/avatar-1.jpg')}}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                @endif
            </div>
            <div class="flex-grow-1 ms-3">
              <div class="dropdown">
                <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,20">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1 me-2">
                      <h6 class="mb-0">{{auth()->user()->name}}</h6>
                      {{-- <small>Administrator</small> --}}
                    </div>
                    <div class="flex-shrink-0">
                      <div class="btn btn-icon btn-link-secondary avtar">
                        <i class="ph-duotone ph-windows-logo"></i>
                      </div>
                    </div>
                  </div>
                </a>
                <div class="dropdown-menu">
                  <ul>
                        <li>
                            <a href="{{route('moncompte')}}" class="pc-user-links">
                            <i class="ph-duotone ph-user"></i>
                            <span>Mon compte</span>
                            </a>
                        </li>

                        @if (auth()->user()->magasin)

                      <li>
                        <a href="{{ route('boutique.qrcode', ['boutiqueSlug' => auth()->user()->boutique->slug]) }}" class="pc-user-links" data-bs-toggle="modal" data-bs-target="#qrCodeModal">
                          <i class="ph-duotone ph-qr-code"></i>
                          <span>QrCode</span>
                        </a>
                      </li>
                      @endif

                    <li>
                      <a href="{{route('logout')}}" class="pc-user-links"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ph-duotone ph-power"></i>
                        <span>Déconnexion</span>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
