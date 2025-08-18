'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    floatchart();
  }, 500);
});

function floatchart() {

  (function () {
    // map

    fetch('/api/user-succursales')
    .then(response => response.json())
    .then(data => {
        console.log('Succursales récupérées :', data); // Vérifiez les données ici
        const markers = data.map(succursale => ({
        coords: [succursale.latitude, succursale.longitude],
        name: succursale.nom_succursale,
        }));

    // Calculer les limites (bounding box) des succursales
    const lats = markers.map(marker => marker.coords[0]);
    const lngs = markers.map(marker => marker.coords[1]);

    const minLat = Math.min(...lats);
    const maxLat = Math.max(...lats);
    const minLng = Math.min(...lngs);
    const maxLng = Math.max(...lngs);

    const map = new jsVectorMap({
      selector: "#world-map-markers",
      map: "world",
      zoomOnScroll: true, // Activer le zoom avec la molette
      zoomButtons: true,  // Ajouter des boutons de zoom
      markersSelectable: true,
      markers: markers,
      markerStyle: {
        initial: {
          fill: '#3f4d67',
        },
        hover: {
          fill: '#04A9F5',
        },
      },
      markerLabelStyle: {
        initial: {
          fontFamily: "'Inter', sans-serif",
          fontSize: 13,
          fontWeight: 500,
          fill: '#3f4d67',
        },
      },
    });
    // Ajuster le zoom et centrer sur les succursales
    map.setFocus({
        scale: 6, // Niveau de zoom (tu peux ajuster ici)
        x: (minLng + maxLng) / 2, // Centre horizontal (longitude)
        y: (minLat + maxLat) / 2, // Centre vertical (latitude)
    });

  })
  .catch(error => console.error('Erreur lors de la récupération des succursales :', error));



    // chart
    var options = {
      chart: {
        type: 'line',
        height: 200,
        toolbar: {
          show: false
        }
      },
      colors: ['#0d6efd'],
      dataLabels: {
        enabled: false
      },
      markers: {
        size: 7,
        colors: '#0d6efd',
        strokeColors: '#fff',
        strokeWidth: 3,
        hover: {
          size: 4,
        }
    },
      stroke: {
        width: 1,
        curve: 'smooth',
      },
      plotOptions: {
        bar: {
          columnWidth: '45%',
          borderRadius: 4
        }
      },
      grid: {
        strokeDashArray: 4
      },
      series: [
        {
          data: [30, 60, 40, 70, 50, 90]
        }
      ],
      yaxis: {
         show: false,
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        labels: {
          hideOverlappingLabels: true,
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      }
    };
    var chart = new ApexCharts(document.querySelector("#earnings-users-chart"), options);
    chart.render();
  })();

}


'use strict';

document.addEventListener('DOMContentLoaded', function () {
    loadYearFilterOptions(); // Charger les années disponibles et afficher le graphique

    setTimeout(function () {
        const observer = new MutationObserver(() => {
            const chartEl = document.querySelector('#bar-chart-1');
            if (chartEl) {
                chartEl.innerHTML = ''; // Supprime l'ancien graphique
                initializeBarChart(); // Recharge le graphique avec les bonnes couleurs
            }
        });

        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['data-pc-theme']
        });

        // Filtrage par année
        const yearFilter = document.querySelector('#yearFilter');
        if (yearFilter) {
            yearFilter.addEventListener('change', function () {
                const chartEl = document.querySelector('#bar-chart-1');
                if (chartEl) {
                    chartEl.innerHTML = ''; // Supprime l'ancien graphique
                    initializeBarChart();
                }
            });
        }
    },500);

});

// Charger dynamiquement les années existantes dans la base
function loadYearFilterOptions() {
    fetch(`/data-bar-chart`) // Récupère toutes les années disponibles
        .then(response => response.json())
        .then(data => {
            const selectYear = document.querySelector('#yearFilter');
            selectYear.innerHTML = ''; // Réinitialiser le select

            data.years.forEach(year => {
                let option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                selectYear.appendChild(option);
            });

            // Sélectionner par défaut l'année en cours ou la plus récente disponible
            selectYear.value = data.selectedYear;

            // ✅ Afficher immédiatement le graphique après avoir défini l'année par défaut
            initializeBarChart();
        })
        .catch(error => console.error('Erreur lors du chargement des années :', error));
}

function initializeBarChart() {
    const selectedYear = document.querySelector('#yearFilter').value; // Récupérer l’année sélectionnée

    fetch(`/data-bar-chart?annee=${selectedYear}`)
        .then(response => response.json())
        .then(data => {
            const categories = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const acomptes = Array(12).fill(0);
            const depenses = Array(12).fill(0);

            data.acomptes.forEach(item => {
                acomptes[item.mois - 1] = item.acompte_total;
            });

            data.depenses.forEach(item => {
                depenses[item.mois - 1] = item.depense_total;
            });

            const darkMode = isDarkMode();

            const optionsBarChart = {
                chart: { height: 350, type: 'bar' },
                plotOptions: { bar: { horizontal: false, columnWidth: '55%', endingShape: 'rounded' } },
                dataLabels: { enabled: false },
                colors: ['#1DE9B6', '#F56767'],
                stroke: { show: true, width: 2, colors: ['transparent'] },
                series: [
                    { name: 'CA', data: acomptes },
                    { name: 'Dépenses', data: depenses }
                ],
                xaxis: {
                    categories: categories,
                    labels: { style: { colors: darkMode ? '#ffffff' : '#333333' } }
                },
                yaxis: {
                    labels: { style: { colors: darkMode ? '#ffffff' : '#333333' } }
                },
                grid: { borderColor: darkMode ? '#444444' : '#E0E0E0' },
                fill: { opacity: 1 },
                tooltip: {
                    theme: darkMode ? 'dark' : 'light',
                    y: { formatter: function (val) { return val.toLocaleString('fr-FR') + ' FCFA'; } }
                }
            };

            const chart = new ApexCharts(document.querySelector('#bar-chart-1'), optionsBarChart);
            chart.render();
        })
        .catch(error => console.error('Erreur lors de la récupération des données :', error));
}

function isDarkMode() {
    return document.body.getAttribute('data-pc-theme') === 'dark';
}


