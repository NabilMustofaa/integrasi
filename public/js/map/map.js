console.log('map.js loaded');

mapboxgl.accessToken = 'pk.eyJ1IjoibHVrYXNtYXJ0aW5lbGxpIiwiYSI6ImNpem85dmhwazAyajIyd284dGxhN2VxYnYifQ.HQCmyhEXZUTz3S98FMrVAQ';

//create map
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v12',
    center: [112.696458,-7.354066],
    minZoom: 2,
    zoom: 15,
    attributionControl: false
});

map.on('load', async function () {
    await map.on('click', setLocation);
});

async function setLocation(e) {
    var coordinates = e.lngLat;
    var longitude = coordinates.lng;
    var latitude = coordinates.lat;
    $('input[name="longitude"]').val(longitude);
    $('input[name="latitude"]').val(latitude);
    flyToStore(longitude, latitude);
}    

$('input[name="longitude"]').on('change', function() {
    var lon = $(this).val();
    var lat = $('input[name="latitude"]').val();
    if (lon != '' && lat != '') {
        flyToStore(lon, lat);
    }
});

$('input[name="latitude"]').on('change', function() {
    var lat = $(this).val();
    var lon = $('input[name="longitude"]').val();
    if (lon != '' && lat != '') {
        flyToStore(lon, lat);
    }
});

$('#get-location').on('click', function() {
    navigator.geolocation.getCurrentPosition(function(position) {
        var lon = position.coords.longitude;
        var lat = position.coords.latitude;
        $('input[name="longitude"]').val(lon);
        $('input[name="latitude"]').val(lat);
        flyToStore(lon, lat);
    });
});

let marker = null;

function flyToStore(lon, lat) {
    map.flyTo({
      center: [lon, lat],
      zoom: 15
    });
    addMarker(lon, lat);
  }

function addMarker(lon, lat) {
    // remove old marker
    if (marker) {
        marker.remove();
    }  

    marker = new mapboxgl.Marker()
        .setLngLat([lon, lat])
        .addTo(map);

}

