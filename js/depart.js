// depart.js

$(document).ready(function() {
    initMap();
    $("#aeroport").change(function() {
        var selectedAeroportName = $(this).val();
        fetchIATACode(selectedAeroportName);
    });
});

function fetchIATACode(aeroportName) {
    $.ajax({
        url: "get_iata.php", // Nommez le fichier PHP qui récupère le code IATA en fonction du nom de l'aéroport
        method: "POST",
        data: { nom: aeroportName },
        dataType: "json",
        success: function(data) {
            var iataCode = data.code;
            fetchFlights(iataCode);
        },
        error: function(error) {
            console.log("Erreur lors de la récupération du code IATA :", error);
        }
    });
}

function fetchFlights(iataCode) {
    $.ajax({
        url: "https://airlabs.co/api/v9/flights",
        data: {
            api_key: "45a17dcc-aebe-42f4-b650-97053dd9096e",
            iata: iataCode,
            limit: 300
        },
        dataType: "json",
        success: function(data) {
            var filteredFlights = filterFlightsByDepartureIATA(data.response, iataCode);
            displayFlightsOnMap(filteredFlights);
        },
        error: function(error) {
            console.log("Erreur lors de la récupération des vols :", error);
        }
    });
}

function filterFlightsByDepartureIATA(flights, iataCode) {
    var filteredFlights = [];

    for (var i = 0; i < 1000; i++) {
        var flight = flights[i];
        if (flight.dep_iata === iataCode) {
            filteredFlights.push(flight);
        }
    }

    return filteredFlights;
}


function initMap(){
    var mapElement = $("#map");
    // Créez une nouvelle carte Leaflet dans la div avec l'ID "map"
    map = L.map(mapElement[0]).setView([0, 0], 2);
        
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
}

// Importez la bibliothèque Leaflet et jQuery si ce n'est pas déjà fait
// <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
// <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

function displayFlightsOnMap(data) {
    // Supprimez les couches précédentes de la carte
    console.log(data);

    map.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });
    // Parcourez les données des vols et créez des marqueurs pour chaque avion
    for (var i = 0; i < data.length; i++) {
        var flight = data[i];

        var icon = L.divIcon({
            className: 'custom-div-icon',
            html: '<img src="image/icon.svg" height="25px" style="transform: rotate(' + flight.dir + 'deg);">',
            iconSize: [25, 25],
            iconAnchor: [12, 12],
        });

        var marker = L.marker([flight.lat, flight.lng], { icon: icon })
            .addTo(map)
            .bindPopup('Altitude: ' + flight.alt + ' m<br>Latitude: ' + flight.lat + '<br>Longitude: ' + flight.lng 
            + '<br>Vitesse : '+ flight.speed + ' km/h<br>IATA de Départ : '+ flight.dep_iata + '<br>IATA Arrivée : ' + flight.arr_iata );
            getDepartureAirportInfo(flight.dep_iata, marker);
            getAirportInfo(flight.arr_iata, marker);
    }
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
