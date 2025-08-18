@extends('admin_layout.admin')

@section('title')
    Category
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <form action="{{route('categorie.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                    <h4 class="mb-0 text-center">Ajouter une catégorie</h4>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Titre</label>
                                        <input type="text" name="nomcategorie" class="form-control" placeholder="Nom de la Categorie">
                                    </div>

                                    @if ($errors->has('nomcategorie'))
                                        <span class="text-danger">{{ $errors->first('nomcategorie') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input class="form-control" name="file" type="file" accept=".jpg, .jpeg, .png, .gif, .webp">
                                    </div>

                                    @if ($errors->has('file'))
                                        <span class="text-danger">{{ $errors->first('file') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3" style="display: none">
                                    <select class="form-select" name="boutique_id">
                                        <option value="{{$magasin->id}}">{{$magasin->nommagasin}}</option>
                                    </select>
                                </div>

                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- [ Main Content ] end -->
    </form>

    </div>
</div>
@endsection
