@extends('admin_layout.admin')

@section('title')
    Creer une boutique
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

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Video de la boutique</label><i> (Facultative)</i>
                                <input class="form-control" name="video" type="file" accept="video/mp4, video/webm, video/ogg">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card border">
                                <div class="card-header">
                                <h5 class="mb-0">Cashback offert</h5>
                                </div>
                                <div class="card-body">
                                {{-- quand la checkbox est décochée, on envoie 0 --}}
                                <input type="hidden" name="cashback_enabled" value="0">

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="cb_enabled" name="cashback_enabled"
                                        value="1" {{ old('cashback_enabled') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cb_enabled">Activer le cashback</label>
                                </div>

                                <div id="cb_fields" class="{{ old('cashback_enabled') ? '' : 'd-none' }}">
                                    <div class="mb-3">
                                    <label class="form-label d-block">Type de cashback</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="cashback_type" id="cb_type_percent" value="percent"
                                            {{ old('cashback_type')==='percent' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cb_type_percent">Pourcentage (%)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="cashback_type" id="cb_type_fixed" value="fixed"
                                            {{ old('cashback_type')==='fixed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cb_type_fixed">Montant (FCFA)</label>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Valeur</label>
                                        <input type="number" class="form-control" id="cb_value" name="cashback_value"
                                            min="1" step="1" value="{{ old('cashback_value') }}">
                                        <small class="text-muted" id="cb_value_help">
                                        Si % : 5 pour 5%. Si montant : 1000 pour 1 000 FCFA.
                                        </small>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Seuil minimum (FCFA)</label>
                                        <input type="number" class="form-control" name="cashback_min_order"
                                            min="0" step="1" value="{{ old('cashback_min_order') }}">
                                        <small class="text-muted">Optionnel. Ex : 10000.</small>
                                    </div>
                                    </div>

                                    <div class="alert alert-info py-2" id="cb_preview" style="display:none;"></div>
                                </div>
                                </div>
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

  <script>
    (function(){
    const enabled = document.getElementById('cb_enabled');
    const fields = document.getElementById('cb_fields');
    const typePercent = document.getElementById('cb_type_percent');
    const typeFixed = document.getElementById('cb_type_fixed');
    const val = document.getElementById('cb_value');
    const minOrder = document.querySelector('input[name="cashback_min_order"]');
    const preview = document.getElementById('cb_preview');
    const help = document.getElementById('cb_value_help');

    function toggle(){
        fields.classList.toggle('d-none', !enabled.checked);
    }
    function updateUI(){
        if (!enabled.checked){ preview.style.display='none'; return; }
        const t = typePercent && typePercent.checked ? 'percent' : (typeFixed && typeFixed.checked ? 'fixed' : null);
        if (t === 'percent'){ val.placeholder='Ex: 5'; val.max=100; help.textContent='Pourcentage: 1–100 (ex: 5 = 5%).'; }
        else if (t === 'fixed'){ val.placeholder='Ex: 1000'; val.removeAttribute('max'); help.textContent='Montant fixe en FCFA (ex: 1000).'; }
        const v = parseInt(val.value || 0,10);
        const m = parseInt(minOrder.value || 0,10);
        let txt='';
        if (t==='percent' && v>0) txt = v+'% de cashback';
        if (t==='fixed' && v>0) txt = new Intl.NumberFormat('fr-FR').format(v)+' FCFA de cashback';
        if (m>0) txt += (txt ? ' ' : '') + 'dès '+ new Intl.NumberFormat('fr-FR').format(m) + ' FCFA';
        preview.textContent = txt || '—';
        preview.style.display = txt ? 'block' : 'none';
    }

    if (enabled) {
        enabled.addEventListener('change', ()=>{toggle(); updateUI();});
        [typePercent, typeFixed, val, minOrder].forEach(el => { if (el) el.addEventListener('input', updateUI); });
        toggle(); updateUI();
    }
    })();
  </script>


@endsection

