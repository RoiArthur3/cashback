@extends('admin_layout.admin')

@section('title')
    Ajouter Produit
@endsection

@section('content')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
      <div class="pc-content">
        <!-- [ Main Content ] start -->
        <form action="{{route('produit.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
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
                            <input type="text" name="nomproduit" class="form-control" placeholder="Entrez le nom du produit" required >
                        </div>

                        <div class="mb-3">
                            <label for="categorie_id" class="form-label">Catégorie</label>
                            <select id="categorie_id" class="form-select" name="categorie_id" required >
                                @foreach ($categories as $categorie)
                                    <option value="{{$categorie->id}}">{{$categorie->nomcategorie}}</option>
                                @endforeach
                            </select>

                            <div class="mb-3" style="display: none">
                                <select class="form-select" name="boutique_id">
                                    <option value="{{$magasin->id}}">{{$magasin->nommagasin}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Description du produit</label>
                            <textarea class="form-control" name="description" placeholder="Entrez la description du produit" required ></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Marque</label>
                            <input type="text" name="marque" class="form-control" placeholder="Entrez le nom de la marque">
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Couleur</label>
                            <input type="text" name="couleur" class="form-control" placeholder="Entrez le nom de la couleur">
                        </div> --}}
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
                              <span class="input-group-text">🤑</span>
                              <input type="number" id="prix" name="prix" class="form-control" placeholder="Entrez le prix" min="0" step="0.01" required aria-label="Prix (Price)">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label d-flex align-items-center"
                              >Reduction <i class="ph-duotone ph-info ms-1" data-bs-toggle="tooltip" data-bs-title="Compare at price"></i
                            ></label>
                            <div class="input-group mb-3">
                              <span class="input-group-text">🤑</span>
                              <input type="number" step="0.01" name="reductionprix" class="form-control" placeholder="Montant de la réduction" />
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
                            <input id="quantity" type="number" class="form-control" name="qty" placeholder="Entrez la quantité" min="1" step="1" required aria-label="Quantity">
                        </div>

                    </div>
                </div>



            </div>
            <div class="col-xl-6">
                {{-- @if(auth()->user()->magasin->type_magasin_id === 4)
                <div class="card">
                    <div class="card-header">
                        <h5>Sélectionnez Pointure</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($pointures as $pointure)
                            <div class="col-auto">
                                <input type="checkbox" class="btn-check" id="btnrdolite-pointure{{ $pointure->id }}" name="pointure_id[]" value="{{ $pointure->id }}">
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
                        <h5>Sélectionnez la taille</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($tailles as $taille)
                            <div class="col-auto">
                                <input type="checkbox" class="btn-check" id="btnrdolite-taille{{ $taille->id }}" name="taille_id[]" value="{{ $taille->id }}">
                                <label class="btn btn-sm btn-light-primary" for="btnrdolite-taille{{ $taille->id }}">{{ $taille->libtaille }}</label>
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
                            <p><span class="text-danger">*</span> La résolution recommandée est de 640 * 640 avec la taille du fichier</p>
                            <input class="form-control" name="file" type="file" accept=".jpg, .jpeg, .png, .gif, .webp">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>Ajoutez plusieurs images</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <p><span class="text-danger">*</span> La résolution recommandée est de 640 * 640 avec la taille du fichier</p>
                            <input class="form-control" name="images[]" type="file" accept=".jpg, .jpeg, .png, .gif, .webp" multiple>
                        </div>
                    </div>
                </div>


               {{--  <div class="card">
                    <div class="card-header">
                        <h5>
                            Mettre en avant le produit réduit
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="selection_promoting">
                                Promouvoir la reduction du produit
                            </label>
                            <input type="checkbox" name="en_vedetteimg" id="selection_promoting">
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="card">
                    <div class="card-header">
                        <h5>Video</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <p><span class="text-danger">*</span> Recommandé 20 Mo avec la taille du fichier</p>
                            <input class="form-control" name="video" type="file" accept="video/mp4, video/webm, video/ogg">
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
                            <input type="checkbox" name="en_vedetteimg" id="selection_promoting">
                        </div>
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-header">
                        <h5>Mettre en avant le produit dans une vidéo</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="selection_video">Promouvoir avec la vidéo</label>
                            <input type="checkbox" name="en_vedette" id="selection_video">
                        </div>
                    </div>
                </div> --}}

                <div class="card">
                    <div class="card-header">
                        <h5>Statut</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-auto">
                                <input type="radio" class="btn-check" id="btnrdolite11" value="Active" name="statut" checked>
                                <label class="btn btn-sm btn-light-success" for="btnrdolite11">Active</label>
                            </div>

                            <div class="col-auto">
                                <input type="radio" class="btn-check" id="btnrdolite13" value="Inactive" name="statut">
                                <label class="btn btn-sm btn-light-danger" for="btnrdolite13">Inactive</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body text-end btn-page">
                        <button class="btn btn-primary mb-0" type="submit">Enregistrer le produit</button>
                        <button class="btn btn-outline-secondary mb-0">Annuler</button>
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
    <!-- [ Main Content ] end -->
    <!-- [Page Specific JS] start -->
    <!-- tagify -->

    @section('scripts')

    <script>
      document.querySelector('input[name="video"]').addEventListener('change', function() {
          const file = this.files[0];
          if (file.size > 30000000) { // 30 MB limit, adjust as needed
              alert('Le fichier est trop volumineux. Veuillez télécharger une vidéo de moins de 30 Mo.');
              this.value = ''; // Clear the input
          }
      });
    </script>

    <script src="{{asset('backend/dist/assets/js/plugins/choices.min.js')}}"></script>
    <script>
      var textRemove = new Choices(document.getElementById('choices-text-remove-button'), {
        delimiter: ',',
        editItems: true,
        maxItemCount: 5,
        removeItemButton: true
      });


    </script>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const fournisseurSelect = document.getElementById("fournisseurSelect");
        const typeMontureSelect = document.getElementById("typeMontureSelect");

        const fournisseurIdInput = document.createElement("input");
        fournisseurIdInput.type = "hidden";
        fournisseurIdInput.name = "fournisseur_id";

        fournisseurSelect.parentNode.appendChild(fournisseurIdInput);

        fournisseurSelect.addEventListener("change", function () {
            const fournisseurId = this.value;

            // Réinitialisation
            fournisseurIdInput.value = "";
            typeMontureSelect.innerHTML = '<option value="">Sélectionnez un type</option>';

            if (!fournisseurId) {
                return;
            }

            fetch(`/fournisseursmonture/id/${fournisseurId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    fournisseurIdInput.value = data.fournisseur_id;

                    // Ajouter les types de montures sans le prix
                    data.type_montures.forEach(monture => {
                        const option = document.createElement("option");
                        option.value = monture.id;
                        option.textContent = monture.libelle;
                        typeMontureSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Erreur lors de la récupération des données :", error);
                });
        });
    });
    </script>

    @endsection
