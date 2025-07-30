@extends('layouts.app')
@section('title', 'Liste de mariage')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-gradient-to-r from-purple-600 to-purple-400 text-white rounded-top-4">
                    <h2 class="mb-0 fw-bold">Créer votre liste de mariage</h2>
                </div>
                <div class="card-body">
                    <form id="mariage-form">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du couple</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date du mariage</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <button type="submit" class="btn btn-purple w-100">Créer la liste</button>
                    </form>
                    <div id="mariage-success" class="alert alert-success d-none mt-3">Liste créée avec succès !</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('mariage-form').addEventListener('submit', function(e) {
    e.preventDefault();
    // Simuler l'envoi AJAX
    document.getElementById('mariage-success').classList.remove('d-none');
    setTimeout(function(){
        document.getElementById('mariage-success').classList.add('d-none');
    }, 2000);
});
</script>
@endsection
