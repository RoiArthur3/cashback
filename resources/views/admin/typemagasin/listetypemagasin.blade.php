@extends('admin_layout.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('backend/dist/assets/css/plugins/style.css')}}">
@endsection

@section('title')
    Product
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
                  <a href="{{route('typeboutique.create')}}" class="btn btn-primary"> <i class="ti ti-plus f-18"></i> Ajouter un type boutique </a>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover tbl-product" id="pc-dt-simple">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $num = 1;
                        @endphp
                        @foreach ($typeboutiques as $typeboutique)
                        <tr>
                            <td>{{ $num++ }}</td>
                            <td>{{$typeboutique->libtypeboutique}}</td>
                            <td class="text-center">
                                <div class="prod-action-links">
                                    <ul class="list-inline me-auto mb-0">
                                      <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                        <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default" data-bs-toggle="offcanvas" data-bs-target="#detailOffcanvas{{ $typeboutique->id }}">
                                          <i class="ti ti-eye f-18"></i>
                                        </a>
                                      </li>
                                      <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                        <a href="{{route('typeboutique.edit',$typeboutique->id)}}" class="avtar avtar-xs btn-link-success btn-pc-default">
                                          <i class="ti ti-edit-circle f-18"></i>
                                        </a>
                                      </li>
                                      <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                        <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $typeboutique->id }}">
                                          <i class="ti ti-trash f-18"></i>
                                        </a>
                                      </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                          <!-- Modal de suppression type produit -->
                          <div class="modal fade" id="deleteModal{{ $typeboutique->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$typeboutique->id}}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="deleteModalLabel{{$typeboutique->id}}">Remove type shop</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form action="{{ route('typeboutique.destroy', $typeboutique->id) }}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <div class="modal-body">
                                              <h5>Are you sure you want to delete <span style="color: red">{{$typeboutique->libtypeboutique}}</span> ?</h5>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                              <button type="submit" class="btn btn-danger">Delete</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>

                          <!-- Offcanvas de détails produit -->
                          <div class="offcanvas offcanvas-end" tabindex="-1" id="detailOffcanvas{{ $typeboutique->id }}" aria-labelledby="detailOffcanvasLabel{{ $typeboutique->id }}">
                            <div class="offcanvas-header">
                              <h5 class="offcanvas-title" id="detailOffcanvasLabel{{ $typeboutique->id }}">Type Shop Details</h5>
                              <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas">
                                <i class="ti ti-x f-20"></i>
                              </a>
                            </div>
                            <div class="offcanvas-body">
                              <div class="card product-card shadow-none border-0">
                                <div class="card-body">
                                  <h5><strong>Type Shop:</strong> {{$typeboutique->libtypeboutique}}</h5>
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
