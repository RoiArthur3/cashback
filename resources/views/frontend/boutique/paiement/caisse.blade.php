@include('frontend.boutique.sousmenu.enteteprincipale')

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="#"><span class="icon_heart_alt"></span>
                <div class="tip">2</div>
            </a></li>
            <li><a href="#"><span class="icon_bag_alt"></span>
                <div class="tip">2</div>
            </a></li>
        </ul>
        <div class="offcanvas__logo">
            <a href="./index.html"><img src="img/logo.png" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
            <a href="#">Login</a>
            <a href="#">Register</a>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    @include('frontend.boutique.sousmenu.header')
    <!-- Header Section End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
  <div class="container">
    @include('frontend.boutique.partials.flash')

    <div class="row">
      <div class="col-lg-12">
        <h6 class="coupon__link">
          <span class="icon_tag_alt"></span>
          <a href="#">Vous avez un coupon ?</a> Cliquez ici pour le saisir.
        </h6>
      </div>
    </div>

    <form action="{{ route('checkout.store', ['boutiqueSlug' => $boutique->slug]) }}" method="POST" class="checkout__form">
      @csrf
      <div class="row">
        <div class="col-lg-8">
          <h5>Informations de facturation</h5>
          <div class="row">
            <div class="col-lg-12">
              <div class="checkout__form__input">
                <p>Nom Complet <span>*</span></p>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
            </div>

            <div class="col-lg-12">
              <div class="checkout__form__input">
                <p>Adresse</p>
                <input type="text" name="address" value="{{ old('address', auth()->user()->address ?? '') }}" placeholder="Adresse de livraison (optionnel)">
                @error('address')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="checkout__form__input">
                <p>Téléphone <span>*</span></p>
                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="checkout__form__input">
                <p>Email</p>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}">
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
            </div>

            {{-- Notes de commande (optionnel) --}}
            <div class="col-lg-12">
              <div class="checkout__form__input">
                <p>Notes de commande</p>
                <input type="text" name="order_note" placeholder="Note de livraison (optionnel)" value="{{ old('order_note') }}">
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="checkout__order">
            <h5>Votre commande — {{ $boutique->nommagasin }}</h5>

            {{-- Récapitulatif panier --}}
            <div class="checkout__order__product">
              <ul>
                <li>
                  <span class="top__text">Produit</span>
                  <span class="top__text__right">Total</span>
                </li>
                @foreach($cart['items'] as $it)
                  <li>
                    {{ $it['name'] }} × {{ $it['qty'] }}
                    <span>{{ number_format($it['subtotal'], 0, ',', ' ') }} FCFA</span>
                  </li>
                @endforeach
              </ul>
            </div>

            @php
              $subtotal = (int) $cart['total_amount'];
              $shipping = 0; $discount = 0;
              $total = max(0, $subtotal + $shipping - $discount);
              $cashback = method_exists($boutique,'computeCashback') ? $boutique->computeCashback($total) : 0;
            @endphp

            <div class="checkout__order__total">
              <ul>
                <li>Sous total <span>{{ number_format($subtotal,0,',',' ') }} FCFA</span></li>
                <li>Total <span>{{ number_format($total,0,',',' ') }} FCFA</span></li>
              </ul>
            </div>

            @if($cashback > 0)
              <div class="alert alert-success py-2">
                Vous gagnerez <strong>{{ number_format($cashback,0,',',' ') }} FCFA</strong> en cashback après paiement.
              </div>
            @endif

            {{-- Méthode de paiement (on branchera le PSP ensuite) --}}
            <div class="checkout__order__widget">
            <label class="d-block mb-2">Moyen de paiement</label>
            <select name="channel" class="form-select">
                <option value="">Choisir sur le portail</option>
                <option value="CARD">Carte</option>
                <option value="OMCIV2">Orange Money CI</option>
                <option value="MOMO">MTN MoMo</option>
                <option value="FLOOZ">Moov Flooz</option>
                <option value="WAVE">WAVE</option>
            </select>
            </div>

            <button type="submit" class="site-btn w-100">Valider la commande</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
        <!-- Checkout Section End -->

        <!-- Footer Section Begin -->
        @include('frontend.boutique.sousmenu.footer')
        <!-- Footer Section End -->

        <!-- Search Begin -->
        <div class="search-model">
            <div class="h-100 d-flex align-items-center justify-content-center">
                <div class="search-close-switch">+</div>
                <form class="search-model-form">
                    <input type="text" id="search-input" placeholder="Search here.....">
                </form>
            </div>
        </div>
        <!-- Search End -->

        <!-- Js Plugins -->
        @include('frontend.boutique.sousmenu.script')
    </body>

    </html>
