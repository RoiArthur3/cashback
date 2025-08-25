@extends('admin_layout.admin')

@section('title')
    Home
@endsection

@section('content')


    <!-- [ Main Content ] start -->
    <div class="pc-container">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin">Accueil</a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                  <li class="breadcrumb-item" aria-current="page">Accueil</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Accueil</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
        @if (auth()->user()->role_id === 3)
        <div class="col-md-3 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden ">
              <div class="card-body">
                <img loading="lazy" src="{{asset('backend/dist/assets/images/widget/img-status-4.svg')}}" alt="img" class="img-fluid img-bg" >
                <h5 class="mb-4">CashBack</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">2</h3>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden ">
              <div class="card-body">
                <img loading="lazy" src="{{asset('backend/dist/assets/images/widget/img-status-4.svg')}}" alt="img" class="img-fluid img-bg" >
                <h5 class="mb-4">Produits</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">{{$nbproduit}}</h3>
                </div>
              </div>
            </div>
          </div>
        @elseif(auth()->user()->role_id === 1)
          <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden ">
              <div class="card-body">
                <img loading="lazy" src="{{asset('backend/dist/assets/images/widget/img-status-4.svg')}}" alt="img" class="img-fluid img-bg" >
                <h5 class="mb-4">Nombre d'utilisateurs</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">{{$nbrusers}}</h3>
                </div>
              </div>
            </div>
          </div>
        @endif

        @if (auth()->user()->role_id === 3)
          <div class="col-md-3 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden ">
              <div class="card-body">
                <img loading="lazy" src="{{asset('backend/dist/assets/images/widget/img-status-5.svg')}}" alt="img" class="img-fluid img-bg" >
                <h5 class="mb-4">Catégories</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">{{$nbcategorie}}</h3>
                </div>
              </div>
            </div>
          </div>

          {{-- <div class="col-md-3 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden ">
              <div class="card-body">
                <img loading="lazy" src="{{asset('backend/dist/assets/images/widget/img-status-4.svg')}}" alt="img" class="img-fluid img-bg" >
                <h5 class="mb-4">Promos</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">{{$nbcouponblackfriday}}</h3>
                </div>
              </div>
            </div>
          </div> --}}


          @elseif(auth()->user()->role_id === 1)
          <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden ">
              <div class="card-body">
                <img loading="lazy" src="{{asset('backend/dist/assets/images/widget/img-status-5.svg')}}" alt="img" class="img-fluid img-bg" >
                <h5 class="mb-4">Nombre de magasins</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">{{$nbmagasin}}</h3>
                </div>
              </div>
            </div>
          </div>
          @endif

          @if($roleId === 1)
  {{-- ADMIN: une seule card CBM --}}
  <div class="col-md-3 col-sm-6">
    <div class="card statistics-card-1 overflow-hidden">
      <div class="card-body">
        <img src="{{ asset('backend/dist/assets/images/widget/img-status-4.svg') }}" class="img-fluid img-bg" alt="">
        <h5 class="mb-2">Cashback CBM (total)</h5>
        <div class="d-flex align-items-baseline gap-2">
          <h3 class="f-w-300 m-b-0">{{ number_format($cbmTotal,0,',',' ') }}</h3><span>FCFA</span>
        </div>
      </div>
    </div>
  </div>
@elseif($roleId === 3)
  {{-- COMMERCIAL: Prime commerciale, Prime parrain, Total --}}
  <div class="col-md-3 col-sm-6">
    <div class="card statistics-card-1 overflow-hidden">
      <div class="card-body">
        <img src="{{ asset('backend/dist/assets/images/widget/img-status-1.svg') }}" class="img-fluid img-bg" alt="">
        <h5 class="mb-2">Mes primes Commercial</h5>
        <div class="d-flex align-items-baseline gap-2">
          <h3 class="f-w-300 m-b-0">{{ number_format($myCommercial,0,',',' ') }}</h3><span>FCFA</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="card statistics-card-1 overflow-hidden">
      <div class="card-body">
        <img src="{{ asset('backend/dist/assets/images/widget/img-status-3.svg') }}" class="img-fluid img-bg" alt="">
        <h5 class="mb-2">Mes primes Parrain</h5>
        <div class="d-flex align-items-baseline gap-2">
          <h3 class="f-w-300 m-b-0">{{ number_format($myParrain,0,',',' ') }}</h3><span>FCFA</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="card statistics-card-1 overflow-hidden">
      <div class="card-body">
        <img src="{{ asset('backend/dist/assets/images/widget/img-status-4.svg') }}" class="img-fluid img-bg" alt="">
        <h5 class="mb-2">Total cumulé</h5>
        <div class="d-flex align-items-baseline gap-2">
          <h3 class="f-w-300 m-b-0">{{ number_format($myTotal,0,',',' ') }}</h3><span>FCFA</span>
        </div>
      </div>
    </div>
  </div>
@else
  {{-- CLIENT: Cashback d’achat, Prime parrain, Total (jamais “commercial”) --}}
  <div class="col-md-3 col-sm-6">
    <div class="card statistics-card-1 overflow-hidden">
      <div class="card-body">
        <img src="{{ asset('backend/dist/assets/images/widget/img-status-2.svg') }}" class="img-fluid img-bg" alt="">
        <h5 class="mb-2">Mon cashback d’achat</h5>
        <div class="d-flex align-items-baseline gap-2">
          <h3 class="f-w-300 m-b-0">{{ number_format($myClient,0,',',' ') }}</h3><span>FCFA</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="card statistics-card-1 overflow-hidden">
      <div class="card-body">
        <img src="{{ asset('backend/dist/assets/images/widget/img-status-3.svg') }}" class="img-fluid img-bg" alt="">
        <h5 class="mb-2">Mes primes Parrain</h5>
        <div class="d-flex align-items-baseline gap-2">
          <h3 class="f-w-300 m-b-0">{{ number_format($myParrain,0,',',' ') }}</h3><span>FCFA</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="card statistics-card-1 overflow-hidden">
      <div class="card-body">
        <img src="{{ asset('backend/dist/assets/images/widget/img-status-4.svg') }}" class="img-fluid img-bg" alt="">
        <h5 class="mb-2">Total cumulé</h5>
        <div class="d-flex align-items-baseline gap-2">
          <h3 class="f-w-300 m-b-0">{{ number_format($myTotal,0,',',' ') }}</h3><span>FCFA</span>
        </div>
      </div>
    </div>
  </div>
@endif


          {{-- <div class="col-md-6 col-xl-6">
            <div class="card">
              <div class="card-header">
                <h5>Succursales</h5>
              </div>
              <div class="card-body">
                <div id="world-map-markers" class="set-map" style="height:365px;"></div>
              </div>
            </div>
          </div> --}}

            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Etat Mensuel Des Chiffres</h5>
                        <select id="yearFilter" class="form-control" style="width: 120px;">
                            <option value="">Toutes les années</option>

                        </select>
                    </div>
                    <div class="card-body">
                        <div id="bar-chart-1"></div>
                    </div>
                </div>
            </div>

        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>
    <!-- [ Main Content ] end -->


@endsection
