@extends('admin_layout.admin')

@section('title')
    Liste des catégories
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
              <a href="{{route('role.create')}}" class="btn btn-primary"> <i class="ti ti-plus f-18"></i> Ajouter un rôle </a>
            </div>
            <div class="table-responsive">
              <table class="table table-hover tbl-product" id="pc-dt-simple">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Action</th>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $num = 1;
                    @endphp
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $num++ }}</td>
                            <td>{{$role->name}}</td>
                            <td>{{$role->description}}</td>
                            <td class="text-center">
                                <div class="prod-action-links">
                                    <ul class="list-inline me-auto mb-0">
                                      <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                        <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default" data-bs-toggle="offcanvas" data-bs-target="#detailOffcanvas{{ $role->id }}">
                                          <i class="ti ti-eye f-18"></i>
                                        </a>
                                      </li>
                                      <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                        <a href="{{route('role.edit',$role->id)}}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                          <i class="ti ti-edit-circle f-18"></i>
                                        </a>
                                      </li>
                                      <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                        <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}">
                                          <i class="ti ti-trash f-18"></i>
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de suppression catégorie -->
                        <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$role->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{$role->id}}">Supprimer la catégorie</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            <h5>Êtes-vous sûr de vouloir supprimer <span style="color: red">{{$role->name}}</span> ?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Offcanvas de détails catégorie -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="detailOffcanvas{{ $role->id }}" aria-labelledby="detailOffcanvasLabel{{ $role->id }}">
                          <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="detailOffcanvasLabel{{ $role->id }}">Détails de la catégorie</h5>
                            <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas">
                              <i class="ti ti-x f-20"></i>
                            </a>
                          </div>
                          <div class="offcanvas-body">
                            <div class="card product-card shadow-none border-0">
                              <div class="card-img-top p-0 text-center">
                                @if($role && $role->image)
                                    <img src="{{ Storage::disk('s3')->url($role->image) }}" alt="Image de la catégorie" class="img-prod img-fluid">
                                @endif
                              </div>
                              <div class="card-body">
                                <h5><strong>Titre:</strong> {{$role->nomrole}}</h5>
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
