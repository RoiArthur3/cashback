@extends('admin_layout.admin')

@section('title')
    Editer Produit
@endsection

@section('content')

<!-- [ Main Content ] start -->

<div class="pc-container">
    <div class="pc-content">
      <!-- [ Main Content ] start -->
      <form action="{{ route('produit.update', $produit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
          <div class="row">
          <!-- [ sample-page ] start -->
          <div class="col-xl-6">
              <div class="card">
                  <div class="card-header">
                      <h5>Description du produit</h5>
                  </div>
                  <div class="card-body">
                      <div class="mb-3">
                          <label class="form-label">Nom du produit</label>
                          <input type="text" name="nomproduit" value="{{ $produit->nomproduit }}" class="form-control" placeholder="Enter Product Name" required >
                      </div>

                      <div class="mb-3">
                          <label for="categorie_id" class="form-label">Catégorie</label>
                          <select id="categorie_id" class="form-select" name="categorie_id" required >
                              @foreach ($categories as $categorie)
                                  <option value="{{$categorie->id}}" @if ($produit->categorie_id == $categorie->id) selected @endif>{{$categorie->nomcategorie}}</option>
                              @endforeach
                          </select>

                          <div class="mb-3" style="display: none">
                              <select class="form-select" name="boutique_id">
                                  <option value="{{$magasin->id}}">{{$magasin->nommagasin}}</option>
                              </select>
                          </div>
                      </div>

                        <div class="mb-0">
                          <label class="form-label">Description</label>
                          <textarea class="form-control" name="description" placeholder="Entrez la description">{{ $produit->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Marque</label>
                            <input type="text" name="marque" value="{{ $produit->marque }}" class="form-control" placeholder="Entrez le nom de la marque">
                        </div>
                  </div>
              </div>

              <div class="card">
                <div class="card-header">
                  <h5>Tarifs</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label d-flex align-items-center"
                          >Prix <i class="ph-duotone ph-info ms-1" data-bs-toggle="tooltip" data-bs-title="Price"></i
                        ></label>
                        <div class="input-group mb-3">
                          <span class="input-group-text">$</span>
                          <input type="number" id="prix" name="prix" value="{{ $produit->prix }}" class="form-control" placeholder="Entrez le prix" min="0" step="0.01" required aria-label="Prix (Price)">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label d-flex align-items-center"
                          >Reduction <i class="ph-duotone ph-info ms-1" data-bs-toggle="tooltip" data-bs-title="Compare at price"></i
                        ></label>
                        <div class="input-group mb-3">
                          <span class="input-group-text">$</span>
                          <input type="number" step="0.01" name="reductionprix" value="{{ $produit->reductionprix }}" class="form-control" placeholder="Montant de la réduction" />
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
            </div>

              <div class="card">
                  <div class="card-header">
                      <h5>Inventaire</h5>
                  </div>
                  <div class="card-body">
                      <div class="mb-3">
                      <label for="quantity" class="form-label">Quantité</label>
                          <input id="quantity" type="number" class="form-control" value="{{ $produit->qty }}" name="qty" placeholder="Enter Quantity" min="1" step="1" required aria-label="Quantity">
                      </div>
                  </div>
              </div>


          </div>
          <div class="col-xl-6">

             {{--  @if(auth()->user()->magasin->type_magasin_id === 4)
                <div class="card">
                    <div class="card-header">
                        <h5>Sélectionnez Pointure</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($pointures as $pointure)
                            <div class="col-auto">
                                <input type="checkbox" class="btn-check" id="btnrdolite-pointure{{ $pointure->id }}" name="pointure_id[]" value="{{ $pointure->id }}"
                                    @if(is_array(json_decode($produit->pointure_id, true)) && in_array($pointure->id, json_decode($produit->pointure_id, true))) checked @endif>
                                <label class="btn btn-sm btn-light-primary" for="btnrdolite-pointure{{ $pointure->id }}">{{ $pointure->libpointure }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif --}}

                @if(auth()->user()->boutique->type_boutique_id === 1)
                <div class="card">
                    <div class="card-header">
                        <h5>Sélectionner la taille</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($tailles as $taille)
                            <div class="col-auto">
                                <input type="checkbox" class="btn-check" id="btnrdolite-taille{{ $taille->id }}" name="taille_id[]" value="{{ $taille->id }}"
                                    @if(is_array(json_decode($produit->taille_id, true)) && in_array($taille->id, json_decode($produit->taille_id, true))) checked @endif>
                                <label class="btn btn-sm btn-light-primary" for="btnrdolite-taille{{ $taille->id }}">{{ $taille->libtypetaille }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
              <div class="card">
                  <div class="card-header">
                      <h5>Image du produit</h5>
                  </div>
                  <div class="card-body">
                      <div class="mb-0">
                        <select id="imageSelection" class="form-control" onchange="showImageInput(this, 'profileImageInput', 'currentImage', 'uploadImage')">
                            <option value="current">Conserver l’image actuelle</option>
                            <option value="upload">Télécharger une nouvelle image</option>
                        </select>
                        <div id="uploadImage" style="display: none;">
                            <input type="file" accept=".jpg, .jpeg, .png, .gif, .webp" name="file" class="form-control-file" id="profileImageInput" onchange="previewSelectedImage(this)">
                            <img id="previewImage" src="" alt="Preview" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div id="currentImage">
                            <label for="profileImageInput" style="cursor: pointer;">
                                <img loading="lazy" id="profileImagePreview" src="{{ asset('storage/' . $produit->image) }}" alt="Image du produit" width="100px">
                            </label>
                        </div>
                    </div>
                  </div>
              </div>

              <!-- ✅ Images multiples -->
            <div class="card">
                <div class="card-header">
                    <h5>Ajoutez plusieurs images</h5>
                </div>
                <div class="card-body">
                    <div class="mb-0">
                        <select id="multipleImageSelection" class="form-control" onchange="showImageInput(this, 'multipleImagesInput', 'currentMultipleImages', 'uploadMultipleImages')">
                            <option value="current">Conserver les images actuelles</option>
                            <option value="upload">Télécharger de nouvelles images</option>
                        </select>
                        <div id="uploadMultipleImages" style="display: none;">
                            <input type="file" accept=".jpg, .jpeg, .png, .gif, .webp" name="images[]" multiple class="form-control-file" id="multipleImagesInput" onchange="previewSelectedMultipleImages(this, 'previewMultipleImages')">
                            <div id="previewMultipleImages" style="display: flex; gap: 10px; margin-top: 10px;"></div>
                        </div>
                        <div id="currentMultipleImages">
                            @if($produit->images)
                                @foreach(json_decode($produit->images, true) as $image)
                                    <img loading="lazy" src="{{ asset('storage/' . $image) }}" alt="Image supplémentaire" width="90" height="75">
                                @endforeach

                            @endif
                        </div>
                    </div>
                </div>
            </div>


              {{-- <div class="card">
                  <div class="card-header">
                      <h5>Video</h5>
                  </div>
                  <div class="card-body">
                    <div class="mb-3">
                        <select id="videoSelection" class="form-control" onchange="showVideoInput(this)">
                            <option value="current">Garder la vidéo actuelle</option>
                            <option value="upload">Mettre en ligne une nouvelle vidéo</option>
                            @if($produit->video && $produit->video !== $produit->magasin->nommagasin . '/videos/')
                                <option value="delete">Supprimer la vidéo actuelle</option>
                            @endif
                        </select>
                        <div id="uploadVideo" style="display: none;">
                            <input type="file" accept="video/mp4, video/webm, video/ogg" name="video" class="form-control-file" id="profileVideoInput">
                        </div>
                        <div id="currentVideo">
                            @if($produit->video)
                            <video width="320" height="240" controls>
                                <source data-src="{{ Storage::disk('s3')->url($produit->video) }}" type="video/mp4">
                                Votre navigateur ne prend pas en charge la balise vidéo.
                            </video>
                            @else
                            <p>Aucune vidéo disponible</p>
                            @endif
                        </div>
                    </div>
                  </div>
              </div> --}}

              <div class="card">
                <div class="card-header">
                    <h5>
                        Mettre en avant le produit
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="selection_promoting">
                            Promouvoir la reduction du produit
                        </label>
                        <input type="checkbox" name="en_vedetteimg" id="en_vedetteimg" {{ $produit->en_vedetteimg ? 'checked' : '' }}>
                      </div>
                </div>
            </div>

              <div class="card">
                <div class="card-header">
                    <h5>Statut</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-auto">
                            <input type="radio" class="btn-check" id="btnrdolite11" value="Active" name="statut"
                                @if(old('statut', $produit->statut) == 'Active') checked @endif>
                            <label class="btn btn-sm btn-light-success" for="btnrdolite11">Active</label>
                        </div>

                        <div class="col-auto">
                            <input type="radio" class="btn-check" id="btnrdolite13" value="Inactive" name="statut"
                                @if(old('statut', $produit->statut) == 'Inactive') checked @endif>
                            <label class="btn btn-sm btn-light-danger" for="btnrdolite13">Inactive</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3" style="display: none">
                <select class="form-select" name="boutique_id">
                    <option value="{{$magasin->id}}">{{$magasin->nommagasin}}</option>
                </select>
            </div>

          </div>
          <div class="col-sm-12">
              <div class="card">
                  <div class="card-body text-end btn-page">
                      <a href="{{ route('produit.index') }}" class="btn btn-outline-secondary mb-0">Retour</a>
                      <button class="btn btn-primary mb-0" type="submit">Modifier le produit</button>
                  </div>
              </div>
          </div>
          <!-- [ sample-page ] end -->
          </div>
      </form>
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
    function showImageInput(select, inputId, currentId, uploadId) {
        var uploadImage = document.getElementById(uploadId);
        var currentImage = document.getElementById(currentId);

        if (select.value === 'upload') {
            uploadImage.style.display = 'block';
            currentImage.style.display = 'none';
        } else {
            uploadImage.style.display = 'none';
            currentImage.style.display = 'block';
        }
    }

    function previewSelectedImage(input, previewId) {
        var preview = document.getElementById(previewId);
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

    function previewSelectedMultipleImages(input, previewContainerId) {
        var container = document.getElementById(previewContainerId);
        container.innerHTML = ''; // Effacer les anciennes prévisualisations

        var files = input.files;
        if (files.length > 0) {
            Array.from(files).forEach(file => {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = "100px";
                    img.style.maxHeight = "100px";
                    img.style.marginRight = "10px";
                    container.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    }
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const fournisseurSelect = document.getElementById("fournisseurSelect");
    const typeMontureSelect = document.getElementById("typeMontureSelect");

    const fournisseurIdInput = document.createElement("input");
    fournisseurIdInput.type = "hidden";
    fournisseurIdInput.name = "fournisseur_id";
    fournisseurSelect.parentNode.appendChild(fournisseurIdInput);

    function loadTypesForFournisseur(fournisseurId, selectedTypeId = null) {
        if (!fournisseurId) {
            typeMontureSelect.innerHTML = '<option value="">Sélectionnez un type</option>';
            return;
        }

        typeMontureSelect.innerHTML = '<option value="">Chargement...</option>';
        fetch(`/fournisseursmonture/id/${fournisseurId}`)
            .then(response => response.json())
            .then(data => {
                typeMontureSelect.innerHTML = '<option value="">Sélectionnez un type</option>';
                fournisseurIdInput.value = data.fournisseur_id;

                data.type_montures.forEach(monture => {
                    const option = document.createElement("option");
                    option.value = monture.id;
                    option.textContent = monture.libelle;

                    // Cocher le type sélectionné à l’édition
                    if (selectedTypeId && monture.id == selectedTypeId) {
                        option.selected = true;
                    }

                    typeMontureSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des données :", error);
            });
    }

    // Écouteur sur le changement du fournisseur
    fournisseurSelect.addEventListener("change", function () {
        loadTypesForFournisseur(this.value);
    });

    // ✅ Chargement initial si on édite
    const initialFournisseurId = fournisseurSelect.value;
    const initialTypeId = `{{ $produit->type_monture_id ?? '' }}`; // blade injecte la valeur ici
    if (initialFournisseurId) {
        loadTypesForFournisseur(initialFournisseurId, initialTypeId);
    }
});
</script>


@endsection
