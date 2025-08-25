@extends('admin_layout.admin')

@section('title')
    Utilisateur
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('backend/dist/assets/css/plugins/style.css')}}">
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
                    @if (auth()->user()->role_id == 1)
                        <a href="{{ route('createuser.admin') }}" class="btn btn-primary"> <i class="ti ti-plus f-18"></i> Ajouter Utilisateur </a>
                    @elseif (auth()->user()->role_id == 3)
                        <a href="{{ route('createuser.commercant') }}" class="btn btn-primary"> <i class="ti ti-plus f-18"></i> Ajouter Utilisateur </a>
                    @endif
                </div>
                <div class="table-responsive">
                  <table class="table table-hover tbl-product" id="pc-dt-simple">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nom et Prénoms</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Role</th>
                        @if (auth()->user()->role_id == 1)
                            <th>Boutique</th>
                        @endif

                        @if (auth()->user()->role_id == 3)
                            <th>Agence</th>
                        @endif
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $num = 1;
                        @endphp
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $num++ }}</td>
                                <td>
                                <div class="row">
                                    <div class="col-auto pe-0">
                                        @if($user && $user->image)
                                            <img src="{{ Storage::disk('s3')->url($user->image) }}" width="36" height="35" style="border-radius: 45%;" class="img-circle elevation-2" alt="">
                                        @else
                                            <img loading="lazy" src="{{ Avatar::create($user->name)->toBase64() }}" alt="user-image" class="wid-40 rounded" >
                                        @endif
                                    </div>
                                    <div class="col">
                                    <h6 class="mb-1 pt-2">{{ $user->name }}</h6>
                                    </div>
                                </div>
                                </td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->numero}}</td>
                                <td>{{$user->role->name}}</td>
                                @if (auth()->user()->role_id == 1)
                                    <td>{{$user->boutique->nommagasin ?? null}}</td>
                                @endif
                                @if (auth()->user()->role_id == 3)
                                <td>
                                    @foreach ($user->succursales as $key => $succursale)
                                        {{ $succursale->zone }}@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                @endif

                                <td class="text-center">

                                <div class="prod-action-links">
                                    <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                        <a
                                        href="#"
                                        class="avtar avtar-xs btn-link-secondary btn-pc-default"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#productOffcanvas"
                                        >
                                        <i class="ti ti-eye f-18"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                        <a href="{{ route('edituser.commercant',$user->id) }}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                        <i class="ti ti-edit-circle f-18"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                        <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="ti ti-trash f-18"></i>
                                        </a>
                                    </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>


                            <!-- Modal de suppression user -->
                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$user->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Supprimer l'etudiant</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        @if (auth()->user()->role_id == 1)
                                            <form action="{{ route('deleteuser.admin', $user->id) }}" method="POST">
                                        @else
                                            <form action="{{ route('deleteuser.commercant', $user->id) }}" method="POST">
                                        @endif
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <h5>Voulez-vous vraiment supprimer <span style="color: red">{{$user->name}}</span> ?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </div>
                                        </form>
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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="productOffcanvas" aria-labelledby="productOffcanvasLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="productOffcanvasLabel">Product Details</h5>
        <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas">
          <i class="ti ti-x f-20"></i>
        </a>
      </div>
      <div class="offcanvas-body">
        <div class="card product-card shadow-none border-0">
          <div class="card-img-top p-0">
            <a href="../application/ecom_product-details.html">
              <img loading="lazy" src="../assets/images/application/img-prod-4.jpg" alt="image" class="img-prod img-fluid">
            </a>
            <div class="card-body position-absolute end-0 top-0">
              <div class="form-check prod-likes">
                <input type="checkbox" class="form-check-input">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart prod-likes-icon"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
              </div>
            </div>
            <div class="card-body position-absolute start-0 top-0">
              <span class="badge bg-danger badge-prod-card">30%</span>
            </div>
          </div>
        </div>
        <h5>Glitter gold Mesh Walking Shoes</h5>
        <p class="text-muted">Image Enlargement: After shooting, you can enlarge photographs of the objects for clear zoomed view. Change In Aspect Ratio: Boldly crop the subject and save it with a composition that has impact.</p>
        <ul class="list-group list-group-flush">
          <li class="list-group-item px-0">
            <div class="d-inline-flex align-items-center justify-content-between w-100">
              <p class="mb-0 text-muted me-1">Price</p>
              <h4 class="mb-0"><b>$299.00</b><span class="mx-2 f-14 text-muted f-w-400 text-decoration-line-through">$399.00</span></h4>
            </div>
          </li>
          <li class="list-group-item px-0">
            <div class="d-inline-flex align-items-center justify-content-between w-100">
              <p class="mb-0 text-muted me-1">Categories</p>
              <h6 class="mb-0">Shoes</h6>
            </div>
          </li>
          <li class="list-group-item px-0">
            <div class="d-inline-flex align-items-center justify-content-between w-100">
              <p class="mb-0 text-muted me-1">Status</p>
              <h6 class="mb-0"><span class="badge bg-warning rounded-pill">Process</span></h6>
            </div>
          </li>
          <li class="list-group-item px-0">
            <div class="d-inline-flex align-items-center justify-content-between w-100">
              <p class="mb-0 text-muted me-1">Brands</p>
              <h6 class="mb-0"><img loading="lazy" src="../assets/images/application/img-prod-brand-1.png" alt="user-image" class="wid-40"></h6>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <!-- [ Main Content ] end -->
    @endsection

    <!-- [Page Specific JS] start -->
    @section('scripts')

    <script src="{{asset('backend/dist/assets/js/plugins/simple-datatables.js')}}"></script>
    <script>
      const dataTable = new simpleDatatables.DataTable('#pc-dt-simple', {
        sortable: false,
        perPage: 5
      });
    </script>

    @endsection
