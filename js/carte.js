
var map;

$(document).ready(function(){
    init();
   
});


function init() {
    // Utilisez l'ID pour sélectionner l'élément du DOM
    var mapElement = $("#map");
    
    if (mapElement.length > 0) {
        map = L.map(mapElement[0]).setView([0, 0], 2);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        getAircraftData();
        // Actualiser toutes les 5 secondes
        setInterval(getAircraftData, 10000);
    } else {
        console.error('Map container not found.');
    }
}


function getAircraftData() {
    //45a17dcc-aebe-42f4-b650-97053dd9096e
    tab = []; 
    $.ajax({
        url: `https://airlabs.co/api/v9/flights?&api_key=c8afdab6-0b87-4565-bfb5-939727e3e803`,
        method: 'GET',
        success: function (data) {
            tab = data.response;
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            for (var i = 0; i < 300; i++) {
                var aircraft = tab[i];
                var icon = L.divIcon({
                    className: 'custom-div-icon',
                    html: '<img src="image/icon.svg" height="25px" style="transform: rotate(' + aircraft.dir + 'deg);">',
                    iconSize: [25, 25],
                    iconAnchor: [12, 12],
                });

                var marker = L.marker([aircraft.lat, aircraft.lng], { icon: icon })
                    .addTo(map)
                    .bindPopup('Altitude: ' + aircraft.alt + ' m<br>Latitude: ' + aircraft.lat + '<br>Longitude: ' + aircraft.lng 
                    + '<br>Vitesse : '+ aircraft.speed + ' km/h<br>IATA de Départ : '+ aircraft.dep_iata + '<br>IATA Arrivée : ' + aircraft.arr_iata );

                getDepartureAirportInfo(aircraft.dep_iata, marker);
                getAirportInfo(aircraft.arr_iata, marker);
                
            }
        },
        error: function (error) {
            console.error('Erreur lors de la récupération des données:', error);
        }
    });
}

function getAirportInfo(iataCode, marker) {
    $.ajax({
        url: 'getAeroport.php',
        method: 'POST',
        data: { code: iataCode },
        success: function (data) {
            marker.bindPopup(marker.getPopup().getContent() + '<br>Aéroport d\'arrivée: ' + data.name );
        },
        error: function (error) {
            console.error('Erreur lors de la récupération des informations sur l\'aéroport:', error);
        }
    });
}

function getDepartureAirportInfo(iataCode, marker) {
    $.ajax({
        url: 'getAeroport.php',
        method: 'POST',
        data: { code: iataCode },
        success: function (data) {
            marker.bindPopup(marker.getPopup().getContent() + '<br>Aéroport de départ: ' + data.name );
        },
        error: function (error) {
            console.error('Erreur lors de la récupération des informations sur l\'aéroport de départ:', error);
        }
    });
}


function toggleDiv(divId) {
    var div = document.getElementById(divId);
    var toggledRadio = document.getElementById(divId + 'Toggle');

    // Masquer toutes les divs
    var allDivs = document.querySelectorAll('div[id^="div"]');
    allDivs.forEach(function (d) {
        d.classList.add('hidden');
    });

    // Afficher la div correspondante au bouton radio sélectionné
    if (toggledRadio.checked) {
        div.classList.remove('hidden');
    }
}

document.addEventListener("DOMContentLoaded", function () {
    var title = document.querySelector("#home h2");

    // Tableau de textes alternatifs
    var titles = ["WELCOME TO", "BIENVENUE CHEZ "];
    var currentIndex = 0;

    // Fonction pour mettre à jour le texte du titre
    function updateTitle() {
        title.textContent = titles[currentIndex];
        currentIndex = (currentIndex + 1) % titles.length;
    }

    // Mettez à jour le titre toutes les 5 secondes
    setInterval(updateTitle, 5000);

    // Appelez la fonction pour initialiser le titre
    updateTitle();
});

document.addEventListener("DOMContentLoaded", function () {
    var toggle_menu = document.querySelector(".responsive-menu");
    var menu = document.querySelector(".menu");

    toggle_menu.onclick = function () {
        toggle_menu.classList.toggle("active");
        menu.classList.toggle("responsive");
    };
}); 
