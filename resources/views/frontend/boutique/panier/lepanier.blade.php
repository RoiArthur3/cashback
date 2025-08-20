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
                        <a href="./index.html"><i class="fa fa-home"></i> Accueil</a>
                        <span>Panier</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            <div id="flashArea">@include('frontend.boutique.partials.flash')</div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        @if(empty($cart['items']))
                            <div class="alert alert-info">Votre panier est vide.</div>
                        @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cartBody">
                                @foreach($cart['items'] as $it)
                                <tr class="cart-row" data-id="{{ $it['id'] }}">
                                    <td class="cart__product__item">
                                        <img src="{{ asset('storage/' . $it['image']) }}" alt="" style="width:70px;height:70px;object-fit:cover;">
                                        <div class="cart__product__item__title">
                                            <h6> <a href="{{ route('leproduit', ['boutiqueSlug'=>$boutique->slug,'slug'=>$it['slug']]) }}">
                                                    {{ $it['name'] }}
                                                </a>
                                            </h6>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price" data-price="{{ $it['price'] }}">
                                        {{ number_format($it['price'],0,',',' ') }}
                                    </td>
                                    <td class="cart__quantity">
                                    <div class="pro-qty" data-id="{{ $it['id'] }}" data-max="{{ $it['stock'] }}">
                                        <span class="dec qtybtn">-</span>
                                        <input type="text" class="qty-input" value="{{ $it['qty'] }}">
                                        <span class="inc qtybtn">+</span>
                                    </div>
                                    <small class="text-muted d-block">Stock : {{ $it['stock'] }}</small>
                                    </td>
                                    <td class="cart__total">
                                        <span class="subtotal-val">{{ number_format($it['subtotal'],0,',',' ') }}</span>
                                    </td>
                                    <td class="cart__close">
                                        <a href="#" class="js-remove" data-id="{{ $it['id'] }}"><span class="icon_close"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>

             @if(!empty($cart['items']))
            <div class="row mt-3">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn">
                <a href="{{ url()->previous() }}">Continuer les achats</a>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-2">
                <div class="cart__total__procced">
                <h6>Total du panier</h6>
                <ul>
                    <li>Sous total <span id="cartSubtotal">{{ number_format($cart['total_amount'],0,',',' ') }} FCFA</span></li>
                    <li>Total <span id="cartTotal">{{ number_format($cart['total_amount'],0,',',' ') }} FCFA</span></li>
                </ul>
                <a href="{{ route('checkout.show', ['boutiqueSlug' => $boutique->slug]) }}" class="primary-btn">Passer à la caisse</a>
                </div>
            </div>
            </div>
            @endif
        </div>
    </section>
    <!-- Shop Cart Section End -->

    <!-- Instagram Begin -->
    {{-- <div class="instagram">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="img/instagram/insta-1.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="img/instagram/insta-2.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="img/instagram/insta-3.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="img/instagram/insta-4.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="img/instagram/insta-5.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="img/instagram/insta-6.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Instagram End -->

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

