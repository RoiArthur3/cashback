@include('frontend.include.enteteprincipale')
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('frontend.include.header')

    <form method="GET" action="{{ route('lesboutiques') }}" class="mb-4">
    <label for="type_boutique">Filtrer par type de boutique :</label>
    <select name="type_boutique" id="type_boutique" class="form-control w-auto d-inline-block" onchange="this.form.submit()">
        <option value="">Tous les types</option>
        @foreach($typeboutiques as $type)
            <option value="{{ $type->id }}" {{ (int)$typeBoutiqueId === $type->id ? 'selected' : '' }}>
                {{ $type->libtypeboutique }}
            </option>
        @endforeach
    </select>

    @if(request()->has('type_boutique'))
        <a href="{{ route('lesboutiques') }}" class="btn btn-sm btn-secondary ml-2">Réinitialiser</a>
    @endif
</form>


<div class="container py-5">
    <div class="horizontal-scroll-container">
        @foreach($boutiques as $boutique)
            <div class="custom-card-wrapper">
                <div class="custom-card">
                    <a href="{{ route('laboutique',$boutique->slug) }}" class="card-image-link" target="_blank">
                        <img src="{{ asset('storage/' . $boutique->image) }}" alt="{{ $boutique->nommagasin }}">
                    </a>
                    <div class="card-content">
                        <h5 class="text-center">{{ $boutique->nommagasin }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


<style>
    .custom-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.custom-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.12);
}

.card-image-link {
    display: block;
}

.card-image-link img {
    width: 100%;
    height: 200px;
    object-fit: contain;
    background-color: #f9f9f9; /* léger fond pour combler */
    padding: 10px;
}


.card-image-link:hover img {
    transform: scale(1.05);
}

.card-content {
    padding: 1rem;
    flex-grow: 1;
    text-align: center;
}

.card-content h5 {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 0.3rem;
    color: #333;
}

.card-content p {
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
    color: #666;
}

.horizontal-scroll-container {
    display: flex;
    overflow-x: auto;
    gap: 16px;
    padding: 10px;
}

.custom-card-wrapper {
    flex: 0 0 auto; /* empêche le redimensionnement */
    width: 250px;   /* largeur fixe */
}


</style>

    <!-- Footer -->
    @include('frontend.include.footer')
</body>
</html>
