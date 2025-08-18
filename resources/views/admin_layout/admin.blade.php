<!DOCTYPE html>
<html lang="fr">
  <!-- [Head] start -->

  <head>

    <!-- Basic Page Information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <title>Tableau de bord | eMakethe</title>
    <meta name="description" content="Access the shop dashboard for eMakethe to manage and oversee all aspects of your e-commerce platform efficiently.">

    <!-- Search Engine Optimization (SEO) -->
    <meta name="keywords" content="eMakethe, tableau de bord de magasin, gestion du commerce en ligne, commerce en ligne, emakethe.africa">
    <meta name="author" content="eMakethe">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Metadata (For Social Media Sharing) -->
    <meta property="og:title" content="Tableau de bord | eMakethe">
    <meta property="og:description" content="Accédez au tableau de bord de magasin pour eMakethe afin de gérer et superviser efficacement tous les aspects de votre plateforme de commerce en ligne.">
    <meta property="og:image" content="https://rwandamarketplace.s3-accelerate.amazonaws.com/public/rwanda-marketplace-high-resolution-logo.png">
    <meta property="og:url" content="https://emakethe.africa/">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#ffffff">

    <!-- Twitter Card Metadata -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Tableau de bord | eMakethe">
    <meta name="twitter:description" content="Gérez efficacement tous les aspects de votre site e-commerce avec le tableau de bord de la boutique eMakethe.">
    <meta name="twitter:image" content="https://rwandamarketplace.s3-accelerate.amazonaws.com/public/rwanda-marketplace-high-resolution-logo.png">

    <!-- Favicon -->
    <link rel="icon" href="https://rwandamarketplace.s3.eu-west-3.amazonaws.com/public/favicon_io/android-chrome-192x192.png">

    <!-- Canonical Link -->
    <link rel="canonical" href="https://emakethe.africa/">

    @yield('style')

    <!-- map-vector css -->
    <link rel="stylesheet" href="{{asset('backend/dist/assets/css/plugins/jsvectormap.min.css')}}">
    <!-- [Google Font : Public Sans] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{asset('backend/dist/assets/fonts/tabler-icons.min.css')}}" >
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{asset('backend/dist/assets/fonts/feather.css')}}" >
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{asset('backend/dist/assets/fonts/fontawesome.css')}}" >
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{asset('backend/dist/assets/fonts/material.css')}}" >
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{asset('backend/dist/assets/css/style.css')}}" id="main-style-link" >
    <link rel="stylesheet" href="{{asset('backend/dist/assets/css/style-preset.css')}}" >

    <style>
        body {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        body.ready {
            opacity: 1;
        }
    </style>

  </head>
  <!-- [Head] end -->
  <!-- [Body] Start -->

  <body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
@include('admin.include.sidebarmenu')
<!-- [ Sidebar Menu ] end -->
<!-- [ Header Topbar ] start -->
@include('admin.include.header')
<!-- [ Header ] end -->

{{-- start content --}}
@yield('content')
{{-- end content--}}

  @include('admin.include.footer')



  @include('admin.include.setting')



  <!-- [Page Specific JS] start -->
  <script src="{{asset('backend/dist/assets/js/plugins/apexcharts.min.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/plugins/jsvectormap.min.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/plugins/world.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/plugins/world-merc.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/pages/dashboard-default.js')}}"></script>
  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="{{asset('backend/dist/assets/js/plugins/popper.min.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/plugins/simplebar.min.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/plugins/bootstrap.min.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/fonts/custom-font.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/pcoded.js')}}"></script>
  <script src="{{asset('backend/dist/assets/js/plugins/feather.min.js')}}"></script>

  <script src="{{ asset('backend/dist/assets/js/plugins/choices.min.js') }}"></script>

  <script>
      document.addEventListener('DOMContentLoaded', function () {
        var genericExamples = document.querySelectorAll('[data-trigger]');
        for (i = 0; i < genericExamples.length; ++i) {
          var element = genericExamples[i];
          new Choices(element, {
            placeholderValue: 'This is a placeholder set in the config',
            searchPlaceholderValue: 'This is a search placeholder'
          });
        }

        var textRemove = new Choices(document.getElementById('choices-text-remove-button'), {
          delimiter: ',',
          editItems: true,
          maxItemCount: 5,
          removeItemButton: true
        });

        var text_Unique_Val = new Choices('#choices-text-unique-values', {
          paste: false,
          duplicateItemsAllowed: false,
          editItems: true
        });

        var text_i18n = new Choices('#choices-text-i18n', {
          paste: false,
          duplicateItemsAllowed: false,
          editItems: true,
          maxItemCount: 5,
          addItemText: function (value) {
            return 'Appuyez sur Entrée pour ajouter <b>"' + String(value) + '"</b>';
          },
          maxItemText: function (maxItemCount) {
            return String(maxItemCount) + 'valeurs peuvent être ajoutées';
          },
          uniqueItemText: 'Cette valeur est déjà présente'
        });

        var textEmailFilter = new Choices('#choices-text-email-filter', {
          editItems: true,
          addItemFilter: function (value) {
            if (!value) {
              return false;
            }

            const regex =
              /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            const expression = new RegExp(regex.source, 'i');
            return expression.test(value);
          }
        }).setValue(['joe@bloggs.com']);

        var textDisabled = new Choices('#choices-text-disabled', {
          addItems: false,
          removeItems: false
        }).disable();

        var textPrependAppendVal = new Choices('#choices-text-prepend-append-value', {
          prependValue: 'item-',
          appendValue: '-' + Date.now()
        }).removeActiveItems();

        var textPresetVal = new Choices('#choices-text-preset-values', {
          items: [
            'Josh Johnson',
            {
              value: 'joe@bloggs.co.uk',
              label: 'Joe Bloggs',
              customProperties: {
                description: 'Joe Blogg is such a generic name'
              }
            }
          ]
        });

        var multipleDefault = new Choices(document.getElementById('choices-multiple-groups'));

        var multipleFetch = new Choices('#choices-multiple-remote-fetch', {
          placeholder: true,
          placeholderValue: 'Pick an Strokes record',
          maxItemCount: 5
        }).setChoices(function () {
          return fetch('https://api.discogs.com/artists/55980/releases?token=QBRmstCkwXEvCjTclCpumbtNwvVkEzGAdELXyRyW')
            .then(function (response) {
              return response.json();
            })
            .then(function (data) {
              return data.releases.map(function (release) {
                return {
                  value: release.title,
                  label: release.title
                };
              });
            });
        });

        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
          removeItemButton: true
        });

        /* Use label on event */
        var choicesSelect = new Choices('#choices-multiple-labels', {
          removeItemButton: true,
          choices: [
            {
              value: 'One',
              label: 'Label One'
            },
            {
              value: 'Two',
              label: 'Label Two',
              disabled: true
            },
            {
              value: 'Three',
              label: 'Label Three'
            }
          ]
        }).setChoices(
          [
            {
              value: 'Four',
              label: 'Label Four',
              disabled: true
            },
            {
              value: 'Five',
              label: 'Label Five'
            },
            {
              value: 'Six',
              label: 'Label Six',
              selected: true
            }
          ],
          'value',
          'label',
          false
        );

        choicesSelect.passedElement.element.addEventListener('addItem', function (event) {
          document.getElementById('message').innerHTML =
            '<span class="badge bg-light-primary"> You just added "' + event.detail.label + '"</span>';
        });
        choicesSelect.passedElement.element.addEventListener('removeItem', function (event) {
          document.getElementById('message').innerHTML =
            '<span class="badge bg-light-danger"> You just removed "' + event.detail.label + '"</span>';
        });

        var singleFetch = new Choices('#choices-single-remote-fetch', {
          searchPlaceholderValue: 'Search for an Arctic Monkeys record'
        })
          .setChoices(function () {
            return fetch('https://api.discogs.com/artists/391170/releases?token=QBRmstCkwXEvCjTclCpumbtNwvVkEzGAdELXyRyW')
              .then(function (response) {
                return response.json();
              })
              .then(function (data) {
                return data.releases.map(function (release) {
                  return {
                    label: release.title,
                    value: release.title
                  };
                });
              });
          })
          .then(function (instance) {
            instance.setChoiceByValue('Fake Tales Of San Francisco');
          });

        var singleXhrRemove = new Choices('#choices-single-remove-xhr', {
          removeItemButton: true,
          searchPlaceholderValue: "Search for a Smiths' record"
        }).setChoices(function (callback) {
          return fetch('https://api.discogs.com/artists/83080/releases?token=QBRmstCkwXEvCjTclCpumbtNwvVkEzGAdELXyRyW')
            .then(function (res) {
              return res.json();
            })
            .then(function (data) {
              return data.releases.map(function (release) {
                return {
                  label: release.title,
                  value: release.title
                };
              });
            });
        });

        var singleNoSearch = new Choices('#choices-single-no-search', {
          searchEnabled: false,
          removeItemButton: true,
          choices: [
            {
              value: 'One',
              label: 'Label One'
            },
            {
              value: 'Two',
              label: 'Label Two',
              disabled: true
            },
            {
              value: 'Three',
              label: 'Label Three'
            }
          ]
        }).setChoices(
          [
            {
              value: 'Four',
              label: 'Label Four',
              disabled: true
            },
            {
              value: 'Five',
              label: 'Label Five'
            },
            {
              value: 'Six',
              label: 'Label Six',
              selected: true
            }
          ],
          'value',
          'label',
          false
        );

        var singlePresetOpts = new Choices('#choices-single-preset-options', {
          placeholder: true
        }).setChoices(
          [
            {
              label: 'Group one',
              id: 1,
              disabled: false,
              choices: [
                {
                  value: 'Child One',
                  label: 'Child One',
                  selected: true
                },
                {
                  value: 'Child Two',
                  label: 'Child Two',
                  disabled: true
                },
                {
                  value: 'Child Three',
                  label: 'Child Three'
                }
              ]
            },
            {
              label: 'Group two',
              id: 2,
              disabled: false,
              choices: [
                {
                  value: 'Child Four',
                  label: 'Child Four',
                  disabled: true
                },
                {
                  value: 'Child Five',
                  label: 'Child Five'
                },
                {
                  value: 'Child Six',
                  label: 'Child Six'
                }
              ]
            }
          ],
          'value',
          'label'
        );

        var singleSelectedOpt = new Choices('#choices-single-selected-option', {
          searchFields: ['label', 'value', 'customProperties.description'],
          choices: [
            {
              value: 'One',
              label: 'Label One',
              selected: true
            },
            {
              value: 'Two',
              label: 'Label Two',
              disabled: true
            },
            {
              value: 'Three',
              label: 'Label Three',
              customProperties: {
                description: 'This option is fantastic'
              }
            }
          ]
        }).setChoiceByValue('Two');

        var customChoicesPropertiesViaDataAttributes = new Choices('#choices-with-custom-props-via-html', {
          searchFields: ['label', 'value', 'customProperties']
        });

        var singleNoSorting = new Choices('#choices-single-no-sorting', {
          shouldSort: false
        });

        var cities = new Choices(document.getElementById('cities'));
        var tubeStations = new Choices(document.getElementById('tube-stations')).disable();

        cities.passedElement.element.addEventListener('change', function (e) {
          if (e.detail.value === 'London') {
            tubeStations.enable();
          } else {
            tubeStations.disable();
          }
        });

        var customTemplates = new Choices(document.getElementById('choices-single-custom-templates'), {
          callbackOnCreateTemplates: function (strToEl) {
            var classNames = this.config.classNames;
            var itemSelectText = this.config.itemSelectText;
            return {
              item: function (classNames, data) {
                return strToEl(
                  '\
                                <div\
                                class="' +
                    String(classNames.item) +
                    ' ' +
                    String(data.highlighted ? classNames.highlightedState : classNames.itemSelectable) +
                    '"\
                                data-item\
                                data-id="' +
                    String(data.id) +
                    '"\
                                data-value="' +
                    String(data.value) +
                    '"\
                                ' +
                    String(data.active ? 'aria-selected="true"' : '') +
                    '\
                                ' +
                    String(data.disabled ? 'aria-disabled="true"' : '') +
                    '\
                                >\
                                <span style="margin-right:10px;">🎉</span> ' +
                    String(data.label) +
                    '\
                                </div>\
                                '
                );
              },
              choice: function (classNames, data) {
                return strToEl(
                  '\
                                <div\
                                class="' +
                    String(classNames.item) +
                    ' ' +
                    String(classNames.itemChoice) +
                    ' ' +
                    String(data.disabled ? classNames.itemDisabled : classNames.itemSelectable) +
                    '"\
                                data-select-text="' +
                    String(itemSelectText) +
                    '"\
                                data-choice \
                                ' +
                    String(data.disabled ? 'data-choice-disabled aria-disabled="true"' : 'data-choice-selectable') +
                    '\
                                data-id="' +
                    String(data.id) +
                    '"\
                                data-value="' +
                    String(data.value) +
                    '"\
                                ' +
                    String(data.groupId > 0 ? 'role="treeitem"' : 'role="option"') +
                    '\
                                >\
                                <span style="margin-right:10px;">👉🏽</span> ' +
                    String(data.label) +
                    '\
                                </div>\
                                '
                );
              }
            };
          }
        });

        var resetSimple = new Choices(document.getElementById('reset-simple'));

        var resetMultiple = new Choices('#reset-multiple', {
          removeItemButton: true
        });
      });
  </script>

<script>
    // Fonction pour changer le thème et enregistrer le choix dans localStorage
    function layout_change(layout) {
      console.log('Applying layout:', layout);

      // Appliquer le thème à l'attribut data-pc-theme
      document.body.setAttribute('data-pc-theme', layout);

      // Mettre à jour les images pour le thème choisi
      updateThemeImages(layout === 'dark' ? 'white' : 'dark');

      // Enregistrer le thème dans localStorage
      localStorage.setItem('theme', layout);
      console.log('Theme saved in localStorage:', layout);
    }

    function updateThemeImages(color) {
      const logoSrc = `../assets/images/logo-${color}.svg`;
      document.querySelectorAll('.pc-sidebar .m-header .logo-lg, .navbar-brand .logo-lg, .landing-logo, .auth-main.v1 .auth-sidefooter img, .footer-top .footer-logo').forEach(el => {
        if (el) {
          el.setAttribute('src', logoSrc);
        }
      });
    }

    // Fonction pour appliquer le thème stocké
    function applyStoredTheme() {
      const storedTheme = localStorage.getItem('theme');
      if (storedTheme) {
        console.log('Applying stored theme:', storedTheme);
        layout_change(storedTheme); // Appliquer le thème stocké
      } else {
        console.log('No theme found in localStorage');
      }
    }

    // Fonction pour réinitialiser le thème au thème par défaut
    function layout_change_default() {
      document.body.removeAttribute('data-pc-theme');
      localStorage.removeItem('theme');
      console.log('Theme reset to default');
      // Réinitialiser les images des logos à leur état par défaut
      updateThemeImages('dark');
    }

    // Appel de la fonction lors du chargement de la page
    document.addEventListener('DOMContentLoaded', applyStoredTheme);

    // ✅ Fonction pour changer la couleur d'accentuation et l'enregistrer dans localStorage
function changeAccentColor(value) {
    console.log("Applying accent color:", value);

    // ✅ Appliquer la couleur à l'attribut `data-pc-preset`
    document.body.setAttribute("data-pc-preset", value);

    // ✅ Stocker la couleur choisie dans localStorage
    localStorage.setItem("accentColor", value);

    // ✅ Mettre à jour les boutons actifs
    updateActiveColorButton(value);
}

// ✅ Fonction pour appliquer la couleur stockée après un rafraîchissement
// Appliquer la couleur enregistrée après un rafraîchissement
function applyStoredAccentColor() {
    const storedColor = localStorage.getItem("accentColor");
    if (storedColor) {
        console.log("Applying stored accent color:", storedColor);
        preset_change(storedColor);
        updateActiveColorButton(storedColor);
    }

    // ✅ Rendre la page visible après l'application de la couleur
    document.body.classList.add("ready");
}


// ✅ Fonction pour mettre à jour les boutons actifs
function updateActiveColorButton(activeColor) {
    document.querySelectorAll(".theme-color.preset-color a").forEach((el) => {
        if (el.getAttribute("data-value") === activeColor) {
            el.classList.add("active");
        } else {
            el.classList.remove("active");
        }
    });
}

// ✅ Ajouter un event listener sur les boutons de couleur
document.querySelectorAll(".theme-color.preset-color a").forEach((el) => {
    el.addEventListener("click", function () {
        const colorClass = this.getAttribute("data-value");
        changeAccentColor(colorClass);
    });
});

// ✅ Appliquer la couleur stockée après le chargement
document.addEventListener("DOMContentLoaded", applyStoredAccentColor);

</script>

<script>
    (function() {
      var storedColor = localStorage.getItem("accentColor");
      if (storedColor) {
        document.documentElement.style.setProperty('--pc-accent-color', storedColor);
        document.body.setAttribute("data-pc-preset", storedColor);
      }
    })();
</script>


  <script>layout_sidebar_change('light');</script>


  <script>change_box_container('false');</script>


  <script>layout_caption_change('true');</script>


  <script>layout_rtl_change('false');</script>


  <script>preset_change("preset-1");</script>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const copyBtn = document.getElementById('copyLinkBtn');
    const linkInput = document.getElementById('boutiqueLink');

    copyBtn.addEventListener('click', function () {
      linkInput.select();
      document.execCommand('copy');

      // Optionnel : Feedback visuel
      copyBtn.innerHTML = '<i class="bi bi-check-circle text-success"></i>';
      setTimeout(() => {
        copyBtn.innerHTML = '<i class="bi bi-clipboard"></i>';
      }, 1500);
    });
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const downloadBtn = document.getElementById('downloadQrBtn');
    const qrImageUrl = document.querySelector('#qrCodeModal img').src;

    downloadBtn.addEventListener('click', function (e) {
        e.preventDefault();

        fetch(qrImageUrl)
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'qr-code.png';
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            })
            .catch(err => console.error('Erreur lors du téléchargement :', err));
    });
});
</script>



  @yield('scripts')

  @if (auth()->user()->magasin)
    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="qrCodeModalLabel">Votre QR Code Boutique</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ route('boutique.qrcode', ['boutiqueSlug' => auth()->user()->magasin->slug]) }}"
                        alt="QR Code Boutique"
                        class="img-fluid" style="max-width: 250px;"><br>
                    <a id="downloadQrBtn" class="btn btn-primary mt-2" download="qr-code.png">
                        <i class="bi bi-download"></i> <span class="text-white">Télécharger le QR Code</span>
                    </a>
                    <p class="mt-3">Scannez ce code ou copiez le lien de votre boutique :</p>
                    <div class="input-group">
                        <input type="text" id="boutiqueLink" class="form-control"
                               value="{{ url('/shop/' . auth()->user()->magasin->slug) }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copyLinkBtn">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


</body>
<!-- [Body] end -->
</html>
