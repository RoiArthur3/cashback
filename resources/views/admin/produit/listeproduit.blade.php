@extends('admin_layout.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('backend/dist/assets/css/plugins/style.css')}}">
@endsection

@section('title')
    Produit
@endsection

@section('content')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
      <div class="pc-content">
        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- [ sample-page ] start -->
          <div class="col-sm-12">
            <div class="card table-card">
              <div class="card-body">
                <div class="text-end p-sm-4 pb-sm-2">
                  <a href="{{route('produit.create')}}" class="btn btn-primary"> <i class="ti ti-plus f-18"></i>
                        @if(auth()->user()->boutique->type_magasin_id === 5)
                            Ajouter une monture
                        @else
                            Ajouter un produit
                        @endif
                    </a>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover tbl-product" id="pc-dt-simple">
                    <thead>
                      <tr>
                        <th class="text-end">#</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Prix initial</th>
                        <th>Prix actuel</th>
                        <th class="text-end">Quantité</th>
                        <th>Statut</th>
                        <th>Image</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $num = 1;
                        @endphp
                        @foreach ($produits as $produit)
                        <tr>
                            <td class="text-end">{{ $num++ }}</td>
                            <td>
                              <div class="row">
                                <div class="col">
                                  <h6 class="mb-1">{{$produit->nomproduit}}</h6>
                                </div>
                              </div>
                            </td>
                            <td>{{$produit->categorie->nomcategorie}}</td>
                            <td>
                                @if($produit->blackFriday && $produit->blackFriday->is_active)
                                    {{-- Calculer le prix initial correctement sans double addition --}}
                                    {{ $produit->prix / (1 - $produit->blackFriday->percentage / 100) }}
                                @else
                                    {{-- Afficher le prix actuel additionné de la réduction individuelle --}}
                                    {{ $produit->prix + ($produit->reductionprix) }}
                                @endif
                            </td>

                            <td>{{$produit->prix}}</td>

                            <td class="text-end">{{$produit->qty}}</td>
                            <td class="text-center">
                              @if ($produit->statut === 'Active')
                                <i class="ph-duotone ph-check-circle text-success f-24" data-bs-toggle="tooltip" data-bs-title="success"></i>
                              @else
                                <i class="ph-duotone ph-check-circle text-danger f-24" data-bs-toggle="tooltip" data-bs-title="danger"></i>
                              @endif
                            </td>
                            <td class="text-center">
                                <img loading="lazy" src="{{ asset('storage/' . $produit->image) }}" alt="user-image" class="wid-40 rounded imgprod" >
                                <div class="prod-action-links">
                                <ul class="list-inline me-auto mb-0">
                                  <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Voir">
                                    <a
                                      href="#"
                                      class="avtar avtar-xs btn-link-secondary btn-pc-default"
                                      data-bs-toggle="offcanvas"
                                      data-bs-target="#detailOffcanvas{{ $produit->id }}"
                                    >
                                      <i class="ti ti-eye f-18"></i>
                                    </a>
                                  </li>
                                  <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Modifier">
                                    <a href="{{route('produit.edit', $produit->id)}}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                      <i class="ti ti-edit-circle f-18"></i>
                                    </a>
                                  </li>
                                  <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Supprimer">
                                    <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $produit->id }}">
                                      <i class="ti ti-trash f-18"></i>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </td>
                          </tr>

                          <!-- Modal de suppression produit -->
                          <div class="modal fade" id="deleteModal{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$produit->id}}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="deleteModalLabel{{$produit->id}}">Retirer le produit</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form action="{{ route('produit.destroy', $produit->id) }}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <div class="modal-body">
                                              <h5>Êtes-vous sûr de vouloir supprimer <span style="color: red">{{$produit->nomproduit}}</span> ?</h5>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                              <button type="submit" class="btn btn-danger">Supprimer</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>

                          <!-- Offcanvas de détails produit -->
                          <div class="offcanvas offcanvas-end" tabindex="-1" id="detailOffcanvas{{ $produit->id }}" aria-labelledby="detailOffcanvasLabel{{ $produit->id }}">
                            <div class="offcanvas-header">
                              <h5 class="offcanvas-title" id="detailOffcanvasLabel{{ $produit->id }}">Détails du produit</h5>
                              <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas">
                                <i class="ti ti-x f-20"></i>
                              </a>
                            </div>
                            <div class="offcanvas-body">
                              <div class="card product-card shadow-none border-0">
                                <div class="card-img-top p-0 text-center">
                                  <img loading="lazy" src="{{ asset('storage/' . $produit->image) }}" alt="Image du produit" class="img-prod img-fluid">
                                </div>
                                <div class="card-body">
                                  <h5><strong>Nom du produit:</strong> {{$produit->nomproduit}}</h5>
                                  <p class="text-muted"><strong>Description:</strong> {{$produit->description}}</p>
                                   <!-- Ajoutez la vidéo ici -->
                                    <div class="text-center my-3">
                                        @if($produit->video)

                                        <video width="320" height="240" controls>
                                            <source data-src="{{ asset('storage/' . $produit->video) }}" type="video/mp4">
                                            Votre navigateur ne prend pas en charge la balise vidéo.
                                        </video>
                                        @else
                                            <p>Aucune vidéo disponible</p>
                                        @endif
                                    </div>

                                  <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                      <div class="d-inline-flex align-items-center justify-content-between w-100">
                                        <p class="mb-0 text-muted me-1">Prix</p>
                                        <h4 class="mb-0"><b>{{$produit->prix}}</b></h4>
                                      </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                      <div class="d-inline-flex align-items-center justify-content-between w-100">
                                        <p class="mb-0 text-muted me-1">Catégorie</p>
                                        <h6 class="mb-0">{{$produit->categorie->nomcategorie}}</h6>
                                      </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                      <div class="d-inline-flex align-items-center justify-content-between w-100">
                                        <p class="mb-0 text-muted me-1">Quantité</p>
                                        <h6 class="mb-0">{{$produit->qty}}</h6>
                                      </div>
                                    </li>
                                  {{--   @if(auth()->user()->magasin->type_magasin_id == 5)
                                    <li class="list-group-item px-0">
                                        <div class="d-inline-flex align-items-center justify-content-between w-100">
                                          <p class="mb-0 text-muted me-1">Marque</p>
                                          <h6 class="mb-0">{{$produit->marque}}</h6>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="d-inline-flex align-items-center justify-content-between w-100">
                                          <p class="mb-0 text-muted me-1">Couleur</p>
                                          <h6 class="mb-0">{{$produit->couleur}}</h6>
                                        </div>
                                    </li>

                                    <li class="list-group-item px-0">
                                        <div class="d-inline-flex align-items-center justify-content-between w-100">
                                          <p class="mb-0 text-muted me-1">Type Monture</p>
                                          <h6 class="mb-0">{{$produit->typeMonture->libmonture ?? null}}</h6>
                                        </div>
                                    </li>
                                    @endif --}}

                                    <li class="list-group-item px-0">
                                      <div class="d-inline-flex align-items-center justify-content-between w-100">
                                        <p class="mb-0 text-muted me-1">Statut</p>
                                        @if ($produit->statut === 'Active')
                                            <h6 class="mb-0"><span class="badge bg-success rounded-pill">Active</span></h6>
                                        @else
                                            <h6 class="mb-0"><span class="badge bg-danger rounded-pill">Inactive</span></h6>
                                        @endif
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>

    <style>
        .imgprod{
            max-height: 40px;
        }
    </style>

    @endsection

    <!-- [Page Specific JS] start -->
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
    </script>

    @section('scripts')

    <script src="{{asset('backend/dist/assets/js/plugins/simple-datatables.js')}}"></script>
    <script>
      const dataTable = new simpleDatatables.DataTable('#pc-dt-simple', {
        sortable: false,
        perPage: 5
      });
    </script>

    @endsection
