@extends('admin_layout.admin')

@section('title')
    Type Shop
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
                <form action="{{ route('typeboutique.update', $typemagasin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="libtypeboutique" value="{{ $typemagasin->libtypeboutique }}" class="form-control" placeholder="Type de la Boutique">
                            </div>
                        </div>

                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Modifier</button>
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
