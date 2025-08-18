@extends('admin_layout.admin')

@section('content')

<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                @if (auth()->user()->role_id === 1)
                <li class="breadcrumb-item"><a href="{{route('dashboard.admin')}}">Accueil</a></li>
                @endif

                <li class="breadcrumb-item"><a href="javascript: void(0)">Utilisateurs</a></li>
                <li class="breadcrumb-item" aria-current="page">Profil du compte</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Profil du compte</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-lg-5 col-xxl-3">
              <div class="card overflow-hidden">
                <div class="card-body position-relative">
                  <div class="text-center mt-3">
                    <div class="chat-avtar d-inline-flex mx-auto">
                        @if (auth()->user()->image)
                            <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                            src="{{ Storage::disk('s3')->url(auth()->user()->image) }}" alt="User image" style="height:90px">
                        @else
                            <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                            src="{{asset('backend/dist/assets/images/user/avatar-1.jpg')}}" alt="User image" style="height:90px">
                        @endif

                      <i class="chat-badge bg-success me-2 mb-2"></i>
                    </div>
                    <h5 class="mb-0">{{auth()->user()->username}}</h5>

                  </div>
                </div>
                <div class="nav flex-column nav-pills list-group list-group-flush account-pills mb-0" id="user-set-tab"
                  role="tablist" aria-orientation="vertical">
                  <a class="nav-link list-group-item list-group-item-action active" id="user-set-profile-tab"
                    data-bs-toggle="pill" href="#user-set-profile" role="tab" aria-controls="user-set-profile"
                    aria-selected="true">
                    <span class="f-w-500"><i class="ph-duotone ph-user-circle m-r-10"></i>Aperçu du profil</span>
                  </a>
                  <a class="nav-link list-group-item list-group-item-action" id="user-set-information-tab"
                    data-bs-toggle="pill" href="#user-set-information" role="tab" aria-controls="user-set-information"
                    aria-selected="false">
                    <span class="f-w-500"><i class="ph-duotone ph-clipboard-text m-r-10"></i>Mettez à jour votre profil</span>
                  </a>

                  <a class="nav-link list-group-item list-group-item-action" id="user-set-passwort-tab"
                    data-bs-toggle="pill" href="#user-set-passwort" role="tab" aria-controls="user-set-passwort"
                    aria-selected="false">
                    <span class="f-w-500"><i class="ph-duotone ph-key m-r-10"></i>Changer le mot de passe</span>
                  </a>
                </div>
              </div>

            </div>
            <div class="col-lg-7 col-xxl-9">
              <div class="tab-content" id="user-set-tabContent">
                <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel"
                  aria-labelledby="user-set-profile-tab">
                  <div class="card">
                    <div class="card-header">
                      <h5>Détails personnels</h5>
                    </div>
                    <div class="card-body">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                          <div class="row">
                            <div class="col-md-6">
                              <p class="mb-1 text-muted">Nom et prénom</p>
                              <p class="mb-0">{{auth()->user()->nom .' '.auth()->user()->prenom}}</p>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0">
                          <div class="row">
                            <div class="col-md-6">
                              <p class="mb-1 text-muted">Téléphone</p>
                              <p class="mb-0">{{auth()->user()->contact}}</p>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0">
                          <div class="row">
                            <div class="col-md-6">
                              <p class="mb-1 text-muted">Email</p>
                              <p class="mb-0">{{auth()->user()->email}}</p>
                            </div>
                          </div>
                        </li>

                        <li class="list-group-item px-0">
                            <div class="row">
                              <div class="col-md-6">
                                <p class="mb-1 text-muted">Nom d'utilisateur</p>
                                <p class="mb-0">{{auth()->user()->username}}</p>
                              </div>
                            </div>
                          </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="user-set-information" role="tabpanel"
                  aria-labelledby="user-set-information-tab">
                  <form action="{{route('updateprofile',auth()->user()->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="card">
                    <div class="card-header">
                      <h5>Informations personnelles</h5>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" name="nom" value="{{auth()->user()->nom}}">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label">Nom de famille</label>
                            <input type="text" class="form-control" name="prenom" value="{{auth()->user()->prenom}}">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" name="username" value="{{auth()->user()->username}}" readonly>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" value="{{auth()->user()->email}}">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label">Tel</label>
                            <input type="text" class="form-control" name="contact" value="{{auth()->user()->contact}}">
                          </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                              <label class="form-label">Photo</label>
                              <select id="imageSelection" class="form-control" onchange="showImageInput(this)">
                                <option value="current">Conserver l'image actuelle</option>
                                <option value="upload">Télécharger une nouvelle image</option>
                            </select>

                            <div id="uploadImage" style="display: none;">
                                <input type="file" accept=".jpg, .jpeg, .png, .gif, .webp" name="file" class="form-control-file" id="profileImageInput" onchange="previewSelectedImage(this)">
                                <img id="previewImage" src="" alt="Preview" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: none;">
                            </div>
                            <div id="currentImage">
                                <label for="profileImageInput" style="cursor: pointer;">
                                    @if (auth()->user()->image)
                                        <img loading="lazy" id="profileImagePreview" src="{{ Storage::disk('s3')->url(auth()->user()->image) }}" alt="Photo de profil" width="100px">
                                    @else
                                        <img loading="lazy" id="profileImagePreview" src="{{asset('backend/dist/assets/images/user/avatar-1.jpg')}}" alt="Photo de profil" width="100px">
                                    @endif
                                </label>
                            </div>

                            </div>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="text-end btn-page">
                    <div class="btn btn-outline-secondary">Annuler</div>
                    <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                  </div>

                </form>
                </div>
                {{-- <div class="tab-pane fade" id="user-set-account" role="tabpanel" aria-labelledby="user-set-account-tab">
                  <div class="card">
                    <div class="card-header">
                      <h5>Paramètre général</h5>
                    </div>
                    <div class="card-body">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                          <div class="row mb-0">
                            <label class="col-form-label col-md-4 col-sm-12 text-md-end">Nom d'utilisateur <span
                                class="text-danger">*</span></label>
                            <div class="col-md-8 col-sm-12">
                              <input type="text" class="form-control" value="Ashoka_Tano_16">
                              <div class="form-text">
                                Your Profile URL: <a href="#" class="link-primary">https://pc.com/Ashoka_Tano_16</a>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0">
                          <div class="row mb-0">
                            <label class="col-form-label col-md-4 col-sm-12 text-md-end">Account Email <span
                                class="text-danger">*</span></label>
                            <div class="col-md-8 col-sm-12">
                              <input type="text" class="form-control" value="demo@sample.com">
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0">
                          <div class="row mb-0">
                            <label class="col-form-label col-md-4 col-sm-12 text-md-end">Language</label>
                            <div class="col-md-8 col-sm-12">
                              <select class="form-control">
                                <option>Washington</option>
                                <option>India</option>
                                <option>Africa</option>
                                <option>New York</option>
                                <option>Malaysia</option>
                              </select>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0 pb-0">
                          <div class="row mb-0">
                            <label class="col-form-label col-md-4 col-sm-12 text-md-end">Sign in Using <span
                                class="text-danger">*</span></label>
                            <div class="col-md-8 col-sm-12">
                              <select class="form-control">
                                <option>Password</option>
                                <option>Face Recognition</option>
                                <option>Thumb Impression</option>
                                <option>Key</option>
                                <option>Pin</option>
                              </select>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h5>Advance Settings</h5>
                    </div>
                    <div class="card-body">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <div>
                              <p class="mb-1">Secure Browsing</p>
                              <p class="text-muted text-sm mb-0">Browsing Securely ( https ) when it's necessary</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="form-check-input h4 position-relative m-0" type="checkbox" role="switch"
                                checked="">
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <div>
                              <p class="mb-1">Login Notifications</p>
                              <p class="text-muted text-sm mb-0">Notify when login attempted from other place</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="form-check-input h4 position-relative m-0" type="checkbox" role="switch"
                                checked="">
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <div>
                              <p class="mb-1">Login Approvals</p>
                              <p class="text-muted text-sm mb-0">Approvals is not required when login from unrecognized
                                devices.</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="form-check-input h4 position-relative m-0" type="checkbox" role="switch"
                                checked="">
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h5>Recognized Devices</h5>
                    </div>
                    <div class="card-body">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="me-2">
                              <div class="d-flex align-items-center">
                                <div class="avtar bg-light-primary">
                                  <i class="ph-duotone ph-desktop f-24"></i>
                                </div>
                                <div class="ms-2">
                                  <p class="mb-1">Celt Desktop</p>
                                  <p class="mb-0 text-muted">4351 Deans Lane</p>
                                </div>
                              </div>
                            </div>
                            <div class="">
                              <div class="text-success d-inline-block me-2">
                                <i class="fas fa-circle f-10 me-2"></i>
                                Current Active
                              </div>
                              <a href="#!" class="text-danger"><i class="feather icon-x-circle"></i></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="me-2">
                              <div class="d-flex align-items-center">
                                <div class="avtar bg-light-primary">
                                  <i class="ph-duotone ph-device-tablet-camera f-24"></i>
                                </div>
                                <div class="ms-2">
                                  <p class="mb-1">Imco Tablet</p>
                                  <p class="mb-0 text-muted">4185 Michigan Avenue</p>
                                </div>
                              </div>
                            </div>
                            <div class="">
                              <div class="text-muted d-inline-block me-2">
                                <i class="fas fa-circle f-10 me-2"></i>
                                Active 5 days ago
                              </div>
                              <a href="#!" class="text-danger"><i class="feather icon-x-circle"></i></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item px-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="me-2">
                              <div class="d-flex align-items-center">
                                <div class="avtar bg-light-primary">
                                  <i class="ph-duotone ph-device-mobile-camera f-24"></i>
                                </div>
                                <div class="ms-2">
                                  <p class="mb-1">Albs Mobile</p>
                                  <p class="mb-0 text-muted">3462 Fairfax Drive</p>
                                </div>
                              </div>
                            </div>
                            <div class="">
                              <div class="text-muted d-inline-block me-2">
                                <i class="fas fa-circle f-10 me-2"></i>
                                Active 1 month ago
                              </div>
                              <a href="#!" class="text-danger"><i class="feather icon-x-circle"></i></a>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <h5>Active Sessions</h5>
                    </div>
                    <div class="card-body">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 pt-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="me-2">
                              <div class="d-flex align-items-center">
                                <div class="avtar bg-light-primary">
                                  <i class="ph-duotone ph-desktop f-24"></i>
                                </div>
                                <div class="ms-2">
                                  <p class="mb-1">Celt Desktop</p>
                                  <p class="mb-0 text-muted">4351 Deans Lane</p>
                                </div>
                              </div>
                            </div>
                            <button class="btn btn-link-danger">Logout</button>
                          </div>
                        </li>
                        <li class="list-group-item px-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="me-2">
                              <div class="d-flex align-items-center">
                                <div class="avtar bg-light-primary">
                                  <i class="ph-duotone ph-device-tablet-camera f-24"></i>
                                </div>
                                <div class="ms-2">
                                  <p class="mb-1">Moon Tablet</p>
                                  <p class="mb-0 text-muted">4185 Michigan Avenue</p>
                                </div>
                              </div>
                            </div>
                            <button class="btn btn-link-danger">Logout</button>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-body text-end">
                      <button class="btn btn-outline-dark me-2">Clear</button>
                      <button class="btn btn-primary">Update Profile</button>
                    </div>
                  </div>
                </div> --}}
                <form action="{{ route('updatepassword') }}" method="POST">
                    @csrf
                    <div class="tab-pane fade" id="user-set-passwort" role="tabpanel" aria-labelledby="user-set-passwort-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5>Changer le mot de passe</h5>
                            </div>
                            <input type="hidden" name="username" class="form-control" value="{{ auth()->user()->username }}">

                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item pt-0 px-0">
                                        <div class="row mb-0">
                                            <label class="col-form-label col-md-4 col-sm-12 text-md-end">Mot de passe actuel <span class="text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-12">
                                                <input type="password" name="current_password" class="form-control" required>
                                                @if($errors->has('current_password'))
                                                    <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                                @endif
                                                {{-- <div class="form-text">Forgot password? <a href="#" class="link-primary">Click here</a></div> --}}
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="row mb-0">
                                            <label class="col-form-label col-md-4 col-sm-12 text-md-end">Nouveau mot de passe <span class="text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-12">
                                                <input type="password" name="password" class="form-control" required>
                                                @if($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item pb-0 px-0">
                                        <div class="row mb-0">
                                            <label class="col-form-label col-md-4 col-sm-12 text-md-end">Confirmez le mot de passe <span class="text-danger">*</span></label>
                                            <div class="col-md-8 col-sm-12">
                                                <input type="password" name="password_confirmation" class="form-control" required>
                                                @if($errors->has('password_confirmation'))
                                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-end">
                                <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                            </div>
                        </div>
                    </div>
                </form>
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

@section('scripts')

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
