@extends('admin_layout.admin')

@section('title')
    Shop type
@endsection

@section('content')
  <!-- [ Main Content ] start -->
  <div class="pc-container">
      <div class="pc-content">
        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="py-0 col-md-12 mx-auto">
            <div class="card">
              <div class="card-header">
                <h1 class="mb-0 text-center">Créez votre boutique</h5>
              </div>
              <div class="card-body">
                  <form action="{{route('boutique.store')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Nom de la boutique</label>
                                  <input type="text" name="nommagasin" class="form-control" placeholder="Nom de la boutique" required>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Type de boutique</label>
                                  <select name="type_boutique_id" class="form-control" required>
                                      <option value="">Sélectionnez le type de boutique</option>
                                     @foreach ($typesmagasins as $typesmagasin)
                                        <option value="{{ $typesmagasin->id }}"
                                            {{ $typesmagasin->id == 5 ? 'selected' : '' }}>
                                            {{ $typesmagasin->libtypeboutique }}
                                        </option>
                                    @endforeach

                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Registre des entreprises</label> <i>(Facultative)</i>
                                  <input type="text" name="registrecommerce" class="form-control" placeholder="Business register (Optional)">
                              </div>
                          </div>
                          {{-- <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Pays</label>
                                  <select name="pays_id" class="form-control" required>
                                    @foreach ($countries as $countrie)
                                        <option value="{{$countrie->id}}">{{$countrie->name}}</option>
                                    @endforeach
                                  </select>
                              </div>
                          </div> --}}

                          {{-- <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Siège</label>  <i>(Optionnel)</i>
                                  <input type="text" name="ville" class="form-control" placeholder="Market name (Optional)">
                              </div>
                          </div> --}}

                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Adresse</label><i> (Facultative)</i>
                                  <input type="text" name="adresse" class="form-control" placeholder="Ex : Abidjan,Cocody, Riviera 2, 8ème tranche, 28 BP 1234 Abidjan 28">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Contact</label>
                                  <input type="tel" name="contact" class="form-control"  placeholder="+250123456789" pattern="^\+?[1-9]\d{1,14}$" required>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Logo de la boutique</label>
                                  <input class="form-control" name="file" type="file" accept=".jpg, .jpeg, .png, .gif, .webp" required>
                              </div>
                          </div>

                         {{--  <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Image de la boutique</label>
                                  <input class="form-control" name="imgmagasin" type="file" accept=".jpg, .jpeg, .png, .gif, .webp">
                              </div>
                          </div> --}}

                          <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Video de la boutique</label><i> (Facultative)</i>
                                <input class="form-control" name="video" type="file" accept="video/mp4, video/webm, video/ogg">
                            </div>
                        </div>

                          <div class="col-md-12 text-end">
                          <button type="submit" class="btn btn-primary">Créez votre boutique</button>
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

  <!-- [ Main Content ] end -->

  <!-- [Page Specific JS] start -->
  <script>
    document.querySelector('input[name="video"]').addEventListener('change', function() {
        const file = this.files[0];
        if (file.size > 30000000) { // 30 MB limit, adjust as needed
            alert('File is too large. Please upload a video smaller than 30MB.');
            this.value = ''; // Clear the input
        }
    });
  </script>

  @endsection

