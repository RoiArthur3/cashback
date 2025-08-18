@extends('admin_layout.admin')

@section('title')
    Ma Boutique
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
              {{-- <h3 class="mb-0 text-center">My shop</h3> --}}
            </div>
            <div class="card-body">
                <form action="{{route('boutique.update',$boutique->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nom de la boutique</label>
                            <input type="text" name="nommagasin" value="{{$boutique->nommagasin}}" class="form-control" placeholder="Nom de la boutique">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Type de magasin</label>
                            <select name="type_magasin_id" class="form-control">
                                @foreach ($typesmagasins as $typesmagasin)
                                    <option value="{{$typesmagasin->id}}" {{($typesmagasin->id == $boutique->type_magasin_id) ? 'selected' : ''}}>{{$typesmagasin->libtypeboutique}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Registre du commerce</label> <i>(Optionnel)</i>
                                <input type="text" name="registrecommerce" readonly value="{{$boutique->registrecommerce}}" class="form-control" placeholder="Business register (Optional)">
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pays</label>
                            <select name="pays_id" class="form-control" readonly>
                                @foreach ($countries as $countrie)
                                    <option value="{{$countrie->id}}" {{($boutique->pays_id == $countrie->id) ? 'selected' : ''}}>
                                        {{$countrie->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        </div> --}}

                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                            <label class="form-label">Market name</label> <i>(Optional)</i>
                            <input type="text" name="ville" value="{{$boutique->ville}}" readonly class="form-control" placeholder="Market name (Optional)">
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Adresse</label><i>(Optionnel)</i>
                                <input type="text" name="adresse" value="{{$boutique->adresse}}" class="form-control" placeholder="e.g., KG 000 street house number 6, Rwanda">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact" value="{{$boutique->contact}}" class="form-control" placeholder="+250123456789" pattern="^\+?[1-9]\d{1,14}$" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{$boutique->email}}" class="form-control" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Logo de la boutique</label>
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
                                    <img loading="lazy" id="profileImagePreview" src="{{ asset('storage/' . $boutique->image) }}" alt="Profile Image" width="100px">
                                </label>
                            </div>
                        </div>

                      {{--   <div class="col-md-6">
                            <label class="form-label">Image du Magasin</label><i>(Optionnel)</i>
                            <select id="imageSelectionBoutique" class="form-control" onchange="showImageInputBoutique(this)">
                                <option value="current">Maintenir l’image actuelle du magasin</option>
                                <option value="upload">Télécharger une nouvelle image</option>
                            </select>
                            <div id="uploadImageBoutique" style="display: none;">
                                <input type="file" accept=".jpg, .jpeg, .png, .gif, .webp" name="imgmagasin" class="form-control-file" id="profileImageInputBoutique" onchange="previewSelectedImageBoutique(this)">
                                <img id="previewImageBoutique" src="" alt="PreviewBoutique" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                            </div>
                            <div id="currentImageBoutique">
                                <label for="profileImageInputBoutique" style="cursor: pointer;">
                                    <img loading="lazy" id="profileImagePreviewBoutique" src="{{ asset('storage/' . $boutique->imgmagasin) }}" alt="Profile Image" width="100px">
                                </label>
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <label class="form-label">Video</label>
                            <select id="videoSelection" class="form-control" onchange="showVideoInput(this)">
                                <option value="current">Garder la vidéo actuelle</option>
                                <option value="upload">Mettre en ligne une nouvelle vidéo</option>
                            </select>
                            <div id="uploadVideo" style="display: none;">
                                <input type="file" accept="video/mp4, video/webm, video/ogg" name="video" class="form-control-file" id="profileVideoInput">
                            </div>
                            <div id="currentVideo">
                                @if($boutique->video)
                                <video width="320" height="240" controls>
                                    <source data-src="{{ asset('storage/' . $boutique->video) }}" type="video/mp4">
                                        Votre navigateur ne prend pas en charge la balise vidéo.
                                </video>
                                @else
                                <p>Aucune vidéo disponible</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Éditer</button>
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
    document.addEventListener('DOMContentLoaded', function () {
        let videos = document.querySelectorAll('video');

        const loadVideo = (video) => {
            let source = video.querySelector('source');
            source.src = source.dataset.src;
            video.load();
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    loadVideo(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });

        videos.forEach(video => {
            observer.observe(video);
        });
    });

    document.querySelector('input[name="video"]').addEventListener('change', function() {
          const file = this.files[0];
          if (file.size > 30000000) { // 30 MB limit, adjust as needed
              alert('File is too large. Please upload a video smaller than 30MB.');
              this.value = ''; // Clear the input
          }
    });
</script>

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

    function showImageInputBoutique(select) {
        var uploadImageBoutique = document.getElementById('uploadImageBoutique');
        var currentImageBoutique = document.getElementById('currentImageBoutique');

        if (select.value === 'upload') {
            uploadImageBoutique.style.display = 'block';
            currentImageBoutique.style.display = 'none';
        } else {
            uploadImageBoutique.style.display = 'none';
            currentImageBoutique.style.display = 'block';
        }
    }

    function previewSelectedImageBoutique(input) {
        var previewBoutique = document.getElementById('previewImageBoutique');
        var fileBoutique = input.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            previewBoutique.src = e.target.result;
            previewBoutique.style.display = 'block';
        };

        if (fileBoutique) {
            reader.readAsDataURL(fileBoutique);
        } else {
            previewBoutique.style.display = 'none';
        }
    }

    function showVideoInput(select) {
        var uploadVideo = document.getElementById('uploadVideo');
        var currentVideo = document.getElementById('currentVideo');

        if (select.value === 'upload') {
            uploadVideo.style.display = 'block';
            currentVideo.style.display = 'none';
        } else {
            uploadVideo.style.display = 'none';
            currentVideo.style.display = 'block';
        }
    }
</script>
@endsection
