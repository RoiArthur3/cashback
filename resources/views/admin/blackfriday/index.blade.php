@extends('admin_layout.admin')

@section('title')
    Promos
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
                <a href="{{route('black_friday.create')}}" class="btn btn-primary"> <i class="ti ti-plus f-18"></i> Ajouter un Coupon </a>
            </div>
            <span class="mx-4" style="color: red; font-weight:bold">NB : Pour eviter un mauvais calcul du pourcentage, avant d'activer ou modifier un coupon, il faut d'abord désactiver le coupon en cours.</span>
            <div class="table-responsive">
              <table class="table table-hover tbl-product" id="pc-dt-simple">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Pourcentage</th>
                    <th>État</th>
                    <th>Description</th>
                    <th>Activer/Desactiver</th>
                    <th>Image</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $num = 1;
                    @endphp
                    @foreach($blackFridays as $blackFriday)
                        <tr>
                            <td>{{ $num++ }}</td>
                            <td>{{ $blackFriday->percentage }}%</td>
                            <td>{{ $blackFriday->is_active ? 'Actif' : 'Inactif' }}</td>
                            <th>{{ $blackFriday->description }}</th>
                            <td>
                                @if (auth()->user()->role_id == 2)
                                    @if($blackFriday->is_active)
                                        <!-- Désactiver -->
                                        <form action="{{ route('black_friday.toggle') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="black_friday_id" value="{{ $blackFriday->id }}">
                                            <input type="hidden" name="is_active" value="0">
                                            <button type="submit" class="btn btn-danger">Désactiver</button>
                                        </form>
                                    @else
                                        <!-- Activer -->
                                        <form action="{{ route('black_friday.toggle') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="black_friday_id" value="{{ $blackFriday->id }}">
                                            <input type="hidden" name="is_active" value="1">
                                            <button type="submit" class="btn btn-success">Activer</button>
                                        </form>
                                    @endif
                                @endif

                                @if (auth()->user()->role_id == 7)
                                    @if($blackFriday->is_active)
                                        <!-- Désactiver -->
                                        <form action="{{ route('communitymanagerblack_friday.toggle') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="black_friday_id" value="{{ $blackFriday->id }}">
                                            <input type="hidden" name="is_active" value="0">
                                            <button type="submit" class="btn btn-danger">Désactiver</button>
                                        </form>
                                    @else
                                        <!-- Activer -->
                                        <form action="{{ route('communitymanagerblack_friday.toggle') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="black_friday_id" value="{{ $blackFriday->id }}">
                                            <input type="hidden" name="is_active" value="1">
                                            <button type="submit" class="btn btn-success">Activer</button>
                                        </form>
                                    @endif
                                @endif

                            </td>
                            <td>
                                @if($blackFriday && $blackFriday->image)
                                    <img src="{{ Storage::disk('s3')->url($blackFriday->image) }}" width="50" height="50" class="img-circle elevation-2" alt="Black Friday">
                                @endif

                                <div class="prod-action-links">
                                    @if (auth()->user()->role_id == 2)
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                                <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default" data-bs-toggle="offcanvas" data-bs-target="#detailOffcanvas{{ $blackFriday->id }}">
                                                    <i class="ti ti-eye f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="{{route('black_friday.edit',$blackFriday->id)}}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $blackFriday->id }}">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    @elseif (auth()->user()->role_id == 7)
                                        <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                                <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default" data-bs-toggle="offcanvas" data-bs-target="#detailOffcanvas{{ $blackFriday->id }}">
                                                    <i class="ti ti-eye f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                <a href="{{route('communitymanagerblack_friday.edit',$blackFriday->id)}}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                                    <i class="ti ti-edit-circle f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $blackFriday->id }}">
                                                    <i class="ti ti-trash f-18"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    @endif

                                </div>
                            </td>

                        </tr>

                        <!-- Modal de suppression catégorie -->
                        <div class="modal fade" id="deleteModal{{ $blackFriday->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$blackFriday->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{$blackFriday->id}}">Supprimer le coupon</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('black_friday.destroy', $blackFriday->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            <h5>Êtes-vous sûr de vouloir supprimer <span style="color: red">{{$blackFriday->percentage}}</span> ?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Offcanvas de détails black friday -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="detailOffcanvas{{ $blackFriday->id }}" aria-labelledby="detailOffcanvasLabel{{ $blackFriday->id }}">
                          <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="detailOffcanvasLabel{{ $blackFriday->id }}">Détails du coupon</h5>
                            <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas">
                              <i class="ti ti-x f-20"></i>
                            </a>
                          </div>
                          <div class="offcanvas-body">
                            <div class="card product-card shadow-none border-0">
                              <div class="card-img-top p-0 text-center">
                                @if($blackFriday && $blackFriday->image)
                                <img src="{{ Storage::disk('s3')->url($blackFriday->image) }}" alt="Image de la catégorie" class="img-prod img-fluid">
                                @endif
                              </div>
                              <br>
                              <div class="card-body">
                                <h5><strong>Pourcentage:</strong> {{$blackFriday->percentage}} %</h5>
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
