@extends('admin_layout.admin')

@section('title')
Catégorie
@endsection

@section('content')

<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
      <!-- [ Main Content ] start -->
      <div class="row">
        <div class="pt-4 col-md-12">
          <div class="card">
            <div class="card-header">
              {{-- <h3 class="mb-0 text-center">Ma Boutique</h3> --}}
            </div>
            <div class="card-body">
                <form action="{{ route('categorie.update', $categorie->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Titre</label>
                                <input type="text" name="nomcategorie" value="{{ $categorie->nomcategorie }}" class="form-control" placeholder="Nom de la Boutique">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <select id="imageSelection" class="form-control" onchange="showImageInput(this)">
                                    <option value="current">Conserver l’image actuelle</option>
                                    <option value="upload">Télécharger une nouvelle image</option>
                                </select>
                                <div id="uploadImage" style="display: none;">
                                    <input type="file" accept=".jpg, .jpeg, .png, .gif, .webp" name="file" class="form-control-file" id="profileImageInput" onchange="previewSelectedImage(this)">
                                    <img id="previewImage" src="" alt="Preview" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                                </div>
                                <div id="currentImage">
                                    <label for="profileImageInput" style="cursor: pointer;">
                                        @if($categorie && $categorie->image)
                                        <img id="profileImagePreview" src="{{ Storage::disk('s3')->url($categorie->image) }}" alt="Profile Image" width="100px">
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3" style="display: none">
                            <select class="form-select" name="boutique_id">
                                <option value="{{$magasin->id}}">{{$magasin->nommagasin}}</option>
                            </select>
                        </div>

                        <div class="col-sm-12">
                            <div class="card-body text-end btn-page">
                                <a href="{{ route('categorie.index') }}" class="btn btn-outline-secondary mb-0">Retour</a>
                                <button class="btn btn-primary mb-0" type="submit">Editer</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
          </div>
        </div>
      </div>
      <!-- [ Main Content ] end -->
    </div>
</div>
@endsection

@section('scripts')

<script>
    function showImageInput(select) {
        var uploadImage = document.getElementById('uploadImage');
        var currentImage = document.getElementById('currentImage');

        if (select.value === 'upload') {
            uploadImage.style.display = 'block';
            currentImage.style.display = 'none';
        } else {
            uploadImage.style.display = 'none';
            currentImage.style.display = 'block';
        }
    }

    function previewSelectedImage(input) {
        var preview = document.getElementById('previewImage');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection
