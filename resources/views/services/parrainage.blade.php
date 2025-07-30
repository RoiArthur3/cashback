@extends('layouts.app')
@section('title', 'Parrainage')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-top-4">
                    <h2 class="mb-0 fw-bold">Parrainez vos amis et gagnez !</h2>
                </div>
                <div class="card-body">
                    <p>Partagez votre lien de parrainage et gagnez jusqu'à 20€ par inscription.</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="parrainage-link" value="{{ route('register', ['ref' => auth()->id()]) }}" readonly>
                        <button class="btn btn-primary" onclick="copyParrainageLink()">Copier le lien</button>
                    </div>
                    <div id="parrainage-success" class="alert alert-success d-none">Lien copié !</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function copyParrainageLink() {
    var copyText = document.getElementById('parrainage-link');
    copyText.select();
    document.execCommand('copy');
    document.getElementById('parrainage-success').classList.remove('d-none');
    setTimeout(function(){
        document.getElementById('parrainage-success').classList.add('d-none');
    }, 2000);
}
</script>
@endsection
