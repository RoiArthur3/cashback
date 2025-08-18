@extends('admin_layout.admin')

@section('title')
    Utilisateur
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        @if (auth()->user()->role_id == 1)
            <form action="{{route('storeuser.superadmin')}}" method="POST" enctype="multipart/form-data">
        @else
            <form action="{{route('storeuser.admin')}}" method="POST" enctype="multipart/form-data">
        @endif

        @csrf

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                    <h4 class="mb-0 text-center">Ajouter un utilisateur</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" class="form-control" placeholder="Nom">
                                </div>

                                @if ($errors->has('nom'))
                                    <span class="text-danger">{{ $errors->first('nom') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Prenom</label>
                                    <input type="text" name="prenom" class="form-control" placeholder="Prenom">
                                </div>

                                @if ($errors->has('prenom'))
                                    <span class="text-danger">{{ $errors->first('prenom') }}</span>
                                @endif
                            </div>

                            <div class="mb-3" style="display: none">
                                <select class="form-select" name="magasin_id">
                                    <option value="{{$magasin->id}}">{{$magasin->nommagasin}}</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username">
                                </div>

                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>

                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="*********">
                                </div>

                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Contact</label>
                                    <input type="text" name="contact" class="form-control" placeholder="Contact">
                                </div>

                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="form-label">Role</label>
                                    <select name="role_id" id="role-select" class="form-control" required>
                                        <option value="">Sélectionnez un role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->nomrole }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="form-label">Photo</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
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
                                    <option value="{{ $succursale->id }}">{{ $succursale->zone }}</option>
                                  @endforeach
                                  </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 text-end">
                            @if (auth()->user()->role_id == 1)
                                <a href="{{ route('listeuser.superadmin') }}" class="btn btn-outline-secondary mb-0">Retour</a>
                            @else
                                <a href="{{ route('listeuser.admin') }}" class="btn btn-outline-secondary mb-0">Retour</a>
                            @endif
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
      <!-- [ Main Content ] end -->
    </form>

    </div>
</div>

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
@endsection
