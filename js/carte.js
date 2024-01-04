
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
        //setInterval(getAircraftData, 5000);
    } else {
        console.error('Map container not found.');
    }
}

function getAircraftData() {
    tab = []; 
    $.ajax({
        url: `https://airlabs.co/api/v9/flights?&api_key=45a17dcc-aebe-42f4-b650-97053dd9096e`,
        method: 'GET',
        success: function (data) {
            tab = data.response;
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            for (var i = 0; i < 100; i++) {
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


