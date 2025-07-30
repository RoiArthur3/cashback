@extends('layouts.app')
@section('title', 'Top Offres')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-gradient-to-r from-yellow-400 to-yellow-300 text-gray-900 rounded-top-4">
                    <h2 class="mb-0 fw-bold">Top Offres du moment</h2>
                </div>
                <div class="card-body">
                    <div id="top-offres-list">
                        <p>Chargement des offres en cours...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Simuler le chargement AJAX des offres
setTimeout(function(){
    document.getElementById('top-offres-list').innerHTML = '<ul><li>Offre 1 : -20% sur Amazon</li><li>Offre 2 : Cashback doublé chez Nike</li><li>Offre 3 : Livraison gratuite chez Sephora</li></ul>';
}, 1200);
</script>
@endsection
