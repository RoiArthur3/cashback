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

    <div id="flashArea">@include('frontend.boutique.partials.flash')</div>

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="/"><i class="fa fa-home"></i> Accueil</a>
                        <span>Boutique</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <div class="sidebar__categories">
                            <div class="section-title">
                                <h4>Categories</h4>
                            </div>
                            <div class="categories__accordion">
                                <div class="accordion" id="accordionExample">
                                    @php
                                        $currentCategorySlug = request()->route('slug');
                                    @endphp

                                    {{-- (Optionnel) Lien "Tous" --}}
                                    <div class="card">
                                        <div class="card-heading {{ $currentCategorySlug ? '' : 'active' }}">
                                            <a class="{{ $currentCategorySlug ? '' : 'active' }}"
                                            href="{{ route('lescategories', ['boutiqueSlug' => $boutique->slug]) }}">
                                                Tous
                                            </a>
                                        </div>
                                    </div>

                                    @foreach ($categories as $category)
                                        @php
                                            $isActive = ($currentCategorySlug === $category->slug);
                                        @endphp

                                        <div class="card">
                                            <div class="card-heading {{ $isActive ? 'active' : '' }}">
                                                <a class="{{ $isActive ? 'active' : '' }}"
                                                href="{{ route('categorie.produits', ['boutiqueSlug' => $boutique->slug, 'slug' => $category->slug]) }}">
                                                    {{ $category->nomcategorie }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="sidebar__filter">
                            <div class="section-title">
                                <h4>Shop by price</h4>
                            </div>
                            <div class="filter-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="33" data-max="99"></div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <p>Price:</p>
                                        <input type="text" id="minamount">
                                        <input type="text" id="maxamount">
                                    </div>
                                </div>
                            </div>
                            <a href="#">Filter</a>
                        </div>
                        {{-- <div class="sidebar__sizes">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list">
                                <label for="xxs">
                                    xxs
                                    <input type="checkbox" id="xxs">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xs">
                                    xs
                                    <input type="checkbox" id="xs">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xss">
                                    xs-s
                                    <input type="checkbox" id="xss">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="s">
                                    s
                                    <input type="checkbox" id="s">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="m">
                                    m
                                    <input type="checkbox" id="m">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="ml">
                                    m-l
                                    <input type="checkbox" id="ml">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="l">
                                    l
                                    <input type="checkbox" id="l">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xl">
                                    xl
                                    <input type="checkbox" id="xl">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div> --}}
                        {{-- <div class="sidebar__color">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list color__list">
                                <label for="black">
                                    Blacks
                                    <input type="checkbox" id="black">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="whites">
                                    Whites
                                    <input type="checkbox" id="whites">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="reds">
                                    Reds
                                    <input type="checkbox" id="reds">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="greys">
                                    Greys
                                    <input type="checkbox" id="greys">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="blues">
                                    Blues
                                    <input type="checkbox" id="blues">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="beige">
                                    Beige Tones
                                    <input type="checkbox" id="beige">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="greens">
                                    Greens
                                    <input type="checkbox" id="greens">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="yellows">
                                    Yellows
                                    <input type="checkbox" id="yellows">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        @foreach ($produits as $produit)
                            <div class="col-lg-4 col-md-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ asset('storage/' . $produit->image) }}">
                                        @if ($produit->created_at->diffInDays(now()) <= 2)
                                            <div class="label new">New</div>
                                        @endif
                                        <ul class="product__hover">
                                            <li><a href="{{ asset('storage/' . $produit->image) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                            <li>
                                                <a href="#" class="js-add-to-cart"
                                                    data-id="{{ $produit->id }}"
                                                    data-qty="1"
                                                    title="Ajouter au panier">
                                                    <span class="icon_bag_alt"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @php
                                        $prixreduit = $produit->prix + ($produit->reductionprix ?? 0);
                                    @endphp
                                    <div class="product__item__text">
                                        <h6><a href="{{route('leproduit',['boutiqueSlug' => $boutique->slug, 'slug' => $produit->slug])}}">{{$produit->nomproduit}}</a></h6>
                                        {{-- <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div> --}}
                                        <div class="product__price">{{$produit->prix}}<span>
                                            @if(!empty($produit->reductionprix) && $produit->reductionprix > 0)
                                                {{$prixreduit}}
                                            @endif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-12 text-center">
                            <div class="pagination__option">
                                <a href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

    <style>
        .categories__accordion .card-heading a.active,
            .categories__accordion .card-heading.active > a {
            color: #111;           /* adapte à ta charte */
            font-weight: 600;
        }
    </style>

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
