@extends('admin_layout.admin')

@section('title')
    Shop type
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <form action="{{route('typeboutique.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                    <h4 class="mb-0 text-center">Ajouter le Type de la boutique</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Titre</label>
                                    <input type="text" name="libtypeboutique" class="form-control" placeholder="Type de la Boutique">
                                </div>

                                @error('libtypeboutique')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- [ Main Content ] end -->
    </form>

    </div>
</div>
@endsection
