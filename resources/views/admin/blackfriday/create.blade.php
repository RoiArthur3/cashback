@extends('admin_layout.admin')

@section('title')
    Category
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <form action="{{ route('black_friday.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                    <h4 class="mb-0 text-center">Ajouter une promo</h4>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pourcentage de réduction</label>
                                        <input type="number" name="percentage" class="form-control" value="0" required>
                                    </div>

                                    @if ($errors->has('percentage'))
                                        <span class="text-danger">{{ $errors->first('percentage') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control" value="" required>
                                    </div>

                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input class="form-control" name="file" type="file" accept=".jpg, .jpeg, .png, .gif, .webp">
                                    </div>

                                    @if ($errors->has('file'))
                                        <span class="text-danger">{{ $errors->first('file') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3" style="display: none">
                                    <select class="form-select" name="boutique_id">
                                        <option value="{{$magasin->id}}">{{$magasin->nommagasin}}</option>
                                    </select>
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
