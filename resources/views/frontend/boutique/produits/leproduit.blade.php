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
                        <a href="./index.html"><i class="fa fa-home"></i> Accueil</a>
                        <a href="#">{{ $produit->categorie->nomcategorie }}</a>
                        <span>{{ $produit->nomproduit }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
   @php
    // Image principale
    $main = $produit->image ? asset('storage/' . ltrim($produit->image, '/')) : null;

    // Normalise $produit->images en tableau d’URLs
    $others = [];

    if (!empty($produit->images)) {
        if (is_array($produit->images)) {
            $others = array_map(fn($p) => asset('storage/' . ltrim($p, '/')), $produit->images);
        } else {
            $decoded = json_decode($produit->images, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $others = array_map(fn($p) => asset('storage/' . ltrim($p, '/')), $decoded);
            } else {
                // CSV "img1.jpg,img2.jpg"
                $others = collect(explode(',', $produit->images))
                    ->map(fn($p) => trim($p))
                    ->filter()
                    ->map(fn($p) => asset('storage/' . ltrim($p, '/')))
                    ->values()
                    ->all();
            }
        }
    }

    // Si relation, décommentez et adaptez la propriété (ex: ->path)
    // if ($produit->images instanceof \Illuminate\Support\Collection) {
    //     $others = $produit->images->map(fn($i) => asset('storage/' . ltrim($i->path, '/')))->all();
    // }

    // Galerie finale (unique, sans null)
    $gallery = array_values(array_unique(array_filter([$main, ...$others])));
@endphp

<section class="product-details spad">
    <div class="container">
        <div class="row">
            {{-- Colonne images --}}
            <div class="col-lg-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__left product__thumb nice-scroll">
                        @foreach ($gallery as $idx => $img)
                            <a class="pt {{ $idx === 0 ? 'active' : '' }}" href="#product-{{ $idx + 1 }}">
                                <img src="{{ $img }}" alt="{{ $produit->nomproduit }} thumbnail {{ $idx + 1 }}">
                            </a>
                        @endforeach
                    </div>

                    <div class="product__details__slider__content">
                        <div class="product__details__pic__slider owl-carousel">
                            @foreach ($gallery as $idx => $img)
                                <img data-hash="product-{{ $idx + 1 }}"
                                     class="product__big__img"
                                     src="{{ $img }}"
                                     alt="{{ $produit->nomproduit }} image {{ $idx + 1 }}"
                                     height="570">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne infos produit (inchangée) --}}
            <div class="col-lg-6">
                @php
                    $prixreduit = $produit->prix + ($produit->reductionprix ?? 0);
                @endphp
                <div class="product__details__text">
                    <h3>{{ $produit->nomproduit }} <span>Marque: {{ $produit->marque }}</span></h3>
                    <div class="rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <span>( 138 reviews )</span>
                    </div>

                    <div class="product__details__price">{{$produit->prix}}<span>
                        @if(!empty($produit->reductionprix) && $produit->reductionprix > 0)
                                {{$prixreduit}}
                        @endif</span></div>
                    @php
                        use Illuminate\Support\Str;
                    @endphp

                    <p>{{ Str::limit($produit->description, 65, '...') }}</p>

                    <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantité:</span>
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div> 
                            
                            <a href="#" class="cart-btn" data-id="{{ $produit->id }}"><span class="icon_bag_alt"></span> Ajouter au panier</a>
                            <ul>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Disponibilité:</span>
                                    <div class="stock__checkbox">
                                        <label for="stockin">
                                            En stock
                                            <input type="checkbox" id="stockin">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Couleur disponible:</span>
                                    <div class="color__checkbox">
                                        <label for="red">
                                            <input type="radio" name="color__radio" id="red" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label for="black">
                                            <input type="radio" name="color__radio" id="black">
                                            <span class="checkmark black-bg"></span>
                                        </label>
                                        <label for="grey">
                                            <input type="radio" name="color__radio" id="grey">
                                            <span class="checkmark grey-bg"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Taille disponible :</span>
                                    <div class="size__btn">
                                        @foreach ($tailles as $index => $taille)
                                            <label for="taille-{{ $index }}">
                                                <input
                                                    type="checkbox"
                                                    name="tailles[]"
                                                    id="taille-{{ $index }}"
                                                    value="{{ $taille->libtaille }}"
                                                    class="taille-checkbox"
                                                >
                                                {{ $taille->libtaille }}
                                            </label>
                                        @endforeach
                                    </div>
                                </li>


                                {{-- <li>
                                    <span>Promotions:</span>
                                    <p>Free shipping</p>
                                </li> --}}
                            </ul>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="product__details__tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <h6>Description</h6>
                        <p>{{$produit->description}}</p>
                    </div>
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                        <h6>Specification</h6>
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                            quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                            Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                            voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                        consequat massa quis enim.</p>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                            dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                            nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                        quis, sem.</p>
                    </div>
                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                        <h6>Reviews ( 2 )</h6>
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                            quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                            Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                            voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                        consequat massa quis enim.</p>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                            dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                            nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                        quis, sem.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>PRODUITS CONNEXES</h5>
                </div>
            </div>

            @foreach ($produitsCategories as $produitsCategorie)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{ asset('storage/' . $produitsCategorie->image) }}">
                            <div class="label new">New</div>
                            <ul class="product__hover">
                                <li><a href="{{ asset('storage/' . $produitsCategorie->image) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        @php
                            $prixreduit = $produitsCategorie->prix + ($produitsCategorie->reductionprix ?? 0);
                        @endphp
                        <div class="product__item__text">
                            <h6><a href="{{route('leproduit',['boutiqueSlug' => $boutique->slug, 'slug' => $produitsCategorie->slug])}}">{{ $produitsCategorie->nomproduit }}</a></h6>
                            {{-- <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div> --}}

                            <div class="product__price">{{$produitsCategorie->prix}}<span>
                                @if(!empty($produitsCategorie->reductionprix) && $produitsCategorie->reductionprix > 0)
                                        {{$prixreduit}}
                                @endif</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Init du slider + synchro vignettes (si Owl Carousel déjà inclus par ton thème) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof $ !== 'undefined' && $.fn.owlCarousel) {
        const $slider = $('.product__details__pic__slider');
        $slider.owlCarousel({
            items: 1,
            dots: false,
            nav: true,
            URLhashListener: true,
            startPosition: 'URLHash'
        });

        // Active la vignette cliquée
        $('.product__thumb .pt').on('click', function () {
            $('.product__thumb .pt').removeClass('active');
            $(this).addClass('active');
        });
    } else {
        console.warn('Owl Carousel non chargé : vérifie l’inclusion du script de ton thème.');
    }
});
</script>

    <!-- Product Details Section End -->

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

<script>
    document.querySelectorAll('.size__btn').forEach(group => {
        group.querySelectorAll('input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', function () {
                const label = this.closest('label');
                if (this.checked) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            });
        });
    });
</script>

