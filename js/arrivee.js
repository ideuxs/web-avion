// depart.js

var latitude,longitude;
var tableau;
var coordinates;
var currentPolyline;
var selectedAeroportName

$(document).ready(function() {
    initMap();
    $("#aeroport").change(function() {
        selectedAeroportName = $(this).val();
        fetchIATAArrivalCode(selectedAeroportName);
        map.removeLayer(currentPolyline);

    });
   // setInterval(displayFlightsOnMap,20000);

});

function fetchIATAArrivalCode(aeroportName) {
    $.ajax({
        url: "get_iata.php",
        method: "POST",
        data: { nom: aeroportName },
        dataType: "json",
        success: function(data) {
            var iataCode = data.code;
            getAirportLoc(iataCode);
            fetchFlightsArrival(iataCode);
        },
        error: function(error) {
            console.log("Erreur lors de la récupération du code IATA :", error);
        }
    });
}

function fetchFlightsArrival(iataCode) {
    $.ajax({
        url: "https://airlabs.co/api/v9/flights",
        data: {
            api_key: "c8afdab6-0b87-4565-bfb5-939727e3e803",
            iata: iataCode,
            limit: 700
        },
        dataType: "json",
        success: function(data) {
            console.log("okok " + data);
            var filteredFlights = filterFlightsByArrivalIATA(data.response, iataCode);
            displayFlightsOnMap(filteredFlights);
        },
        error: function(error) {
            console.log("Erreur lors de la récupération des vols :", error);
        }
    });
}

function filterFlightsByArrivalIATA(flights, iataCode) {
    var filteredFlights = [];

    for (var i = 0; i < flights.length; i++) {
        var flight = flights[i];
        if (flight.arr_iata === iataCode) {
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

    var icon = L.divIcon({
        className: 'custom-div-icon',
        html: '<img src="image/aeroport.png" height="40px";">',
        iconSize: [35, 35],
        iconAnchor: [12, 12],
    });

    var airportLoc = L.marker([coordinates.latitude, coordinates.longitude], {icon : icon}).addTo(map).bindPopup("Je suis l'aeroport : " + selectedAeroportName);    

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

            marker.on('click', function(e) {
                connectAirportToFlight(e.latlng, airportLoc.getLatLng());
            });

            getDepartureAirportInfo(flight.dep_iata, marker);
            getAirportInfo(flight.arr_iata, marker);
    }

    map.on('click', function(e) {
        if (currentPolyline) {
            map.removeLayer(currentPolyline);
        }
    });

}

function connectAirportToFlight(flightLatLng, airportLatLng) {
    if (currentPolyline) {
        map.removeLayer(currentPolyline);
    }

    // Créer une nouvelle ligne et l'ajouter à la carte
    currentPolyline = L.polyline([flightLatLng, airportLatLng], { color: 'blue' }).addTo(map);
}


function getAirportLoc(iataCode) {
    $.ajax({
        url: 'getLoc.php',
        method: 'POST',
        data: { code: iataCode },
        dataType: 'json',
        success: function (data) {
            coordinates = extractCoordinates(data.location);
            
        },
        error: function (error) {
            console.error('Erreur lors de la récupération des informations sur l\'aéroport:', error);
        }
    });
}


function extractCoordinates(chaine) {
    // Recherche de la partie entre parenthèses (coordonnées)
    var coordinatesString = chaine.match(/\(([^)]+)\)/)[1];
    
    // Séparation des coordonnées en longitude et latitude
    var [longitude, latitude] = coordinatesString.split(' ');

    // Convertir les chaînes en nombres
    longitude = parseFloat(longitude);
    latitude = parseFloat(latitude);

    return { latitude, longitude };
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

document.addEventListener("DOMContentLoaded", function () {
    var toggle_menu = document.querySelector(".responsive-menu");
    var menu = document.querySelector(".menu");

    toggle_menu.onclick = function () {
        toggle_menu.classList.toggle("active");
        menu.classList.toggle("responsive");
    };
});

document.addEventListener("DOMContentLoaded", function () {
    var title = document.querySelector("#home h2");
    var tmp = document.querySelector("#home h4");

    // Tableau de textes alternatifs
    var titles = ["CHERCHEZ UN VOL ", "SEARCH A FLIGHT "];
    var tmps = ["Par Arrivée ", "By Arrival "];
    var currentIndex = 0;
    // Fonction pour mettre à jour le texte du titre
    function updateTitle() {
        title.textContent = titles[currentIndex];
        tmp.textContent = tmps[currentIndex];
        currentIndex = (currentIndex + 1) % titles.length;
    }

    // Mettez à jour le titre toutes les 5 secondes
    setInterval(updateTitle, 5000);

    // Appelez la fonction pour initialiser le titre
    updateTitle();
});
