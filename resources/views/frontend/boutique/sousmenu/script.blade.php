<script src="{{ asset('laboutique/ashion-master/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('laboutique/ashion-master/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('laboutique/ashion-master/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('laboutique/ashion-masterjs/jquery-ui.min.js') }}"></script>
<script src="{{ asset('laboutique/ashion-masterjs/mixitup.min.js') }}"></script>
<script src="{{ asset('laboutique/ashion-master/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('laboutique/ashion-master/js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('laboutique/ashion-master/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('laboutique/ashion-master/js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('laboutique/ashion-master/js/main.js') }}"></script>

<script>
$(function () {
  $.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  });

  const ADD_URL   = "{{ route('cart.add', ['boutiqueSlug' => $boutique->slug]) }}";
  const COUNT_URL = "{{ route('cart.count', ['boutiqueSlug' => $boutique->slug]) }}";

  // petit helper flash (injection DOM)
  function showFlash(msg, type = 'success') {
    const html = `
      <div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${msg}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
      </div>`;
    $('#flashArea').html(html);
    // auto-hide après 3s (optionnel)
    setTimeout(() => { $('.alert').alert('close'); }, 3000);
  }

  // Click sur l’icône sac
  $(document).on('click', '.js-add-to-cart', function(e){
    e.preventDefault();
    const $btn = $(this);
    const id = $btn.data('id');
    const qty = $btn.data('qty') || 1;

    $btn.addClass('loading');

    $.post(ADD_URL, { product_id: id, qty: qty })
      .done(function(res){
        if(res && res.ok){
          $('#cartCount').text(res.count); // met à jour la pastille du header
          showFlash(res.flash, 'success'); // flash instantané
        }
      })
      .fail(function(xhr){
        showFlash('Impossible d’ajouter au panier.', 'danger');
        console.error(xhr.responseText);
      })
      .always(function(){
        $btn.removeClass('loading');
      });
  });

  $(document).on('click', '.cart-btn', function(e){
    e.preventDefault();
    const $btn = $(this);
    const id = $btn.data('id');
    const qty = $btn.data('qty') || 1;

    $btn.addClass('loading');

    $.post(ADD_URL, { product_id: id, qty: qty })
      .done(function(res){
        if(res && res.ok){
          $('#cartCount').text(res.count); // met à jour la pastille du header
          showFlash(res.flash, 'success'); // flash instantané
        }
      })
      .fail(function(xhr){
        showFlash('Impossible d’ajouter au panier.', 'danger');
        console.error(xhr.responseText);
      })
      .always(function(){
        $btn.removeClass('loading');
      });
  });

  // Au chargement, on peut resynchroniser le compteur (optionnel)
  $.get(COUNT_URL).done(function(r){ $('#cartCount').text(r.count || 0); });
});
</script>

<script>
$(function(){
  $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

  const ROUTES = {
    update: "{{ url('/panier/'.$boutique->slug.'/item') }}", // + /{id}
    remove: "{{ url('/panier/'.$boutique->slug.'/item') }}", // + /{id}
  };

  function formatFCFA(n){
    n = parseInt(n || 0, 10);
    return n.toLocaleString('fr-FR') + ' FCFA';
  }

  function showFlash(msg, type='success'){
    const html = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${msg}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
    $('#flashArea').html(html);
    setTimeout(()=>{$('.alert').alert('close')}, 3000);
  }

  function refreshTotals(totalAmount, totalQty){
    $('#cartSubtotal, #cartTotal').text(formatFCFA(totalAmount));
    $('#cartCount').text(totalQty); // badge du header
  }

  function updateRow($row, subtotal){
    $row.find('.subtotal-val').text(formatFCFA(subtotal));
  }

  // +/-
  $(document).on('click', '.pro-qty .qtybtn', function(e){
    e.preventDefault();
    const $wrap = $(this).closest('.pro-qty');
    const max = parseInt($wrap.data('max') || '0', 10);
    const $input = $wrap.find('.qty-input');
    const id = $wrap.data('id');
    let qty = parseInt($input.val() || '1', 10);

    if ($(this).hasClass('inc')) {
        if (qty >= max) { showFlash(`Stock max atteint: ${max}.`, 'warning'); return; }
        qty++;
    } else {
        qty = Math.max(0, qty-1);
    }

    $.ajax({
      url: `${ROUTES.update}/${id}`,
      type: 'PATCH',
      data: { qty: qty }
    }).done(function(res){
      if(!res.ok) return;
      if(res.item){ // encore présent
        $input.val(res.item.qty);
        updateRow($wrap.closest('tr'), res.item.subtotal);
      }else{ // supprimé
        $wrap.closest('tr').remove();
        if(res.cart.is_empty){
          // recharge la section pour afficher "panier vide"
          location.reload();
          return;
        }
      }
      refreshTotals(res.cart.total_amount, res.cart.total_qty);
      showFlash(res.flash, 'success');
    }).fail(function(){
      showFlash("Erreur lors de la mise à jour.", 'danger');
    });
  });

  // saisie manuelle (on applique au blur)
  $(document).on('blur', '.qty-input', function(){
    const $input = $(this);
    const $wrap = $input.closest('.pro-qty');
    const max = parseInt($wrap.data('max') || '0', 10);
    let qty = parseInt($input.val() || '1', 10);
    qty = isNaN(qty) ? 1 : Math.max(0, qty);

    if (max > 0 && qty > max) {
        qty = max;
        $input.val(qty);
        showFlash(`Stock max atteint: ${max}.`, 'warning');
    }

    $.ajax({
      url: `${ROUTES.update}/${id}`,
      type: 'PATCH',
      data: { qty: qty }
    }).done(function(res){
      if(!res.ok) return;
        if(res.item){
            $input.val(res.item.qty);
            updateRow($wrap.closest('tr'), res.item.subtotal);
            if(res.item.max !== undefined) $wrap.attr('data-max', res.item.max);
        }
        if(res.limited){ showFlash(res.flash || 'Stock limité', 'warning'); }
       else {
        $wrap.closest('tr').remove();
        if(res.cart.is_empty){ location.reload(); return; }
      }
      refreshTotals(res.cart.total_amount, res.cart.total_qty);
      showFlash(res.flash, 'success');
    }).fail(function(){
      showFlash("Erreur lors de la mise à jour.", 'danger');
    });
  });

  // suppression
  $(document).on('click', '.js-remove', function(e){
    e.preventDefault();
    const id = $(this).data('id');
    const $row = $(this).closest('tr');
    $.ajax({
      url: `${ROUTES.remove}/${id}`,
      type: 'DELETE'
    }).done(function(res){
      if(!res.ok) return;
      $row.remove();
      if(res.cart.is_empty){ location.reload(); return; }
      refreshTotals(res.cart.total_amount, res.cart.total_qty);
      showFlash(res.flash, 'success');
    }).fail(function(){
      showFlash("Erreur lors de la suppression.", 'danger');
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('useCashbackInput');
  const totalEl = document.getElementById('checkoutTotal');
  const afterEl = document.getElementById('totalAfterRedeem');
  const max = input ? parseInt(input.getAttribute('max') || '0', 10) : 0;

  // Récupère le total initial en nombre
  function parseFcfa(el){
    return parseInt((el.textContent || '0').replace(/[^\d]/g,''), 10) || 0;
  }
  const totalInitial = totalEl ? parseFcfa(totalEl) : 0;

  function fmt(n){
    return new Intl.NumberFormat('fr-FR').format(n) + ' FCFA';
  }

  function update(){
    if (!input || !afterEl) return;
    let v = parseInt(input.value || '0', 10);
    if (v < 0) v = 0;
    if (v > max) v = max;
    input.value = v;
    const toPay = Math.max(0, totalInitial - v);
    afterEl.textContent = fmt(toPay);
  }

  input && (input.oninput = update);
  update();
});
</script>


