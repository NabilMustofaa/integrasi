let stores;
let markers = [];

mapboxgl.accessToken = 'pk.eyJ1IjoibHVrYXNtYXJ0aW5lbGxpIiwiYSI6ImNpem85dmhwazAyajIyd284dGxhN2VxYnYifQ.HQCmyhEXZUTz3S98FMrVAQ';

function addMarker(lon, lat) {
  marker = new mapboxgl.Marker()
      .setLngLat([lon, lat])
      .addTo(map);

  markers.push(marker);

}

//create map
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v12',
    center: [112.696458,-7.354066],
    minZoom: 2,
    zoom: 15,
    attributionControl: false
});

$.ajax({
    url: '/api/store',
    type: 'GET',
    dataType: 'json',
}).done(function(data) {
    stores = data;
    $(function () {
      $("#dataGrid").dxDataGrid({
          dataSource: stores,
          columns: [
            {dataField: "id", caption: "ID",width: 20},
            {dataField: "name", caption: "Store Name"},
            {dataField: "address", caption: "Store Address", hidingPriority: 0},
            {dataField: "sales", groupIndex: 0, caption: "Sales"},
            {dataField: "phone", caption: "Store Phone"},

          ],
          selection: { mode: "single" },
          onSelectionChanged: function(e) {
              e.component.byKey(e.currentSelectedRowKeys[0]).done(function(data) {
                map.flyTo({
                  center: [data.longitude, data.latitude],
                  zoom: 15
                });

              });
          },
      });
    });

    stores.forEach(function(store) {
        addMarker(store.longitude, store.latitude);
    });


});




