@extends('admin_layout.admin')

@section('title')
    Role
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <form action="{{route('role.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                    <h4 class="mb-0 text-center">Ajouter un rôle</h4>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nom du role">
                                    </div>

                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control" placeholder="Description du role">
                                    </div>

                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
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
