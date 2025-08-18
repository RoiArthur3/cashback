@extends('admin_layout.admin')

@section('title')
    Utilisateur
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        @if (auth()->user()->role_id == 1)
            <form action="{{route('updateuser.superadmin',$user->id)}}" method="POST" enctype="multipart/form-data">
        @else
            <form action="{{route('updateuser.admin',$user->id)}}" method="POST" enctype="multipart/form-data">
        @endif

        @method('PUT')
        @csrf

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                    <h4 class="mb-0 text-center">Modifier un utilisateur</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" value="{{ $user->nom }}" class="form-control" placeholder="Nom">
                                </div>

                                @if ($errors->has('nom'))
                                    <span class="text-danger">{{ $errors->first('nom') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Prenom</label>
                                    <input type="text" name="prenom" value="{{ $user->prenom }}" class="form-control" placeholder="Prenom">
                                </div>

                                @if ($errors->has('prenom'))
                                    <span class="text-danger">{{ $errors->first('prenom') }}</span>
                                @endif
                            </div>

                            @if (auth()->user()->magasin)
                                <div class="mb-3" style="display: none">
                                    <select class="form-select" name="magasin_id">
                                        <option value="{{$magasin->id}}">{{$magasin->nommagasin}}</option>
                                    </select>
                                </div>
                            @endif

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" value="{{ $user->username }}" class="form-control" placeholder="Username">
                                </div>

                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
                                </div>

                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Contact</label>
                                    <input type="text" name="contact" value="{{ $user->contact }}" class="form-control" placeholder="Contact">
                                </div>

                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="form-label">Role</label>
                                    <select name="role_id" id="role-select" class="form-control">
                                        <option value="">Sélectionnez un role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{($user->role_id == $role->id) ? 'selected' : ''}}>{{ $role->nomrole }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <select id="imageSelection" class="form-control" onchange="showImageInput(this)">
                                        <option value="current">Conserver l’image actuelle</option>
                                        <option value="upload">Télécharger une nouvelle image</option>
                                    </select>
                                    <div id="uploadImage" style="display: none;">
                                        <input type="file" accept=".jpg, .jpeg, .png, .gif, .webp" name="file" class="form-control-file" id="profileImageInput" onchange="previewSelectedImage(this)">
                                        <img id="previewImage" src="" alt="Preview" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                                    </div>
                                    <div id="currentImage">
                                        <label for="profileImageInput" style="cursor: pointer;">
                                            @if($user && $user->image)
                                            <img id="profileImagePreview" src="{{ Storage::disk('s3')->url($user->image) }}" alt="Profile Image" width="100px">
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if (auth()->user()->magasin)
                            <div class="col-md-6">
                                <label class="form-label">Affecter une zone</label>
                                <div class="mb-3">
                                  <select
                                    class="form-control"
                                    data-trigger
                                    name="succursale_id[]"
                                    id="choices-multiple-default"
                                    multiple
                                  >
                                  @foreach ($succursales as $succursale)
                                    <option value="{{ $succursale->id }}"
                                        {{ in_array($succursale->id, $user->succursales->pluck('id')->toArray()) ? 'selected' : '' }}
                                    >
                                        {{ $succursale->zone }}
                                    </option>
                                @endforeach
                                  </select>
                                </div>
                            </div>
                            @endif

                        </div>

                        <div class="col-md-12 text-end">
                            @if (auth()->user()->role_id == 1)
                                <a href="{{ route('listeuser.superadmin') }}" class="btn btn-outline-secondary mb-0">Retour</a>
                            @else
                                <a href="{{ route('listeuser.admin') }}" class="btn btn-outline-secondary mb-0">Retour</a>
                            @endif
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
      <!-- [ Main Content ] end -->
    </form>

    </div>
</div>

<script>
    function showImageInput(select) {
        var uploadImage = document.getElementById('uploadImage');
        var currentImage = document.getElementById('currentImage');

        if (select.value === 'upload') {
            uploadImage.style.display = 'block';
            currentImage.style.display = 'none';
        } else {
            uploadImage.style.display = 'none';
            currentImage.style.display = 'block';
        }
    }

    function previewSelectedImage(input) {
        var preview = document.getElementById('previewImage');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
</script>

@endsection
