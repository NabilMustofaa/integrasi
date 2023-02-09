const truckLocation = [112.696458, -7.354066];
const warehouseLocation = [112.696458, -7.354066];
let storeLocation = [];
let lastAtRestaurant = Date.now();
let keepTrack = [];
let pointHopper = {};

mapboxgl.accessToken =
    "pk.eyJ1IjoibHVrYXNtYXJ0aW5lbGxpIiwiYSI6ImNpem85dmhwazAyajIyd284dGxhN2VxYnYifQ.HQCmyhEXZUTz3S98FMrVAQ";

//create map
var map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v12",
    center: warehouseLocation,
    minZoom: 2,
    zoom: 15,
    attributionControl: false,
});

const warehouse = turf.point(warehouseLocation);

const dropoffs = turf.featureCollection([]);

const nothing = turf.featureCollection([]);

map.on("load", async function () {
    // Create a circle layer
    map.addLayer({
        id: "warehouse",
        type: "circle",
        source: {
            data: warehouse,
            type: "geojson",
        },
        paint: {
            "circle-radius": 5,
            "circle-color": "white",
            "circle-stroke-color": "#3887be",
            "circle-stroke-width": 3,
        },
    });

    // Create a symbol layer on top of circle layer
    map.addLayer({
        id: "warehouse-symbol",
        type: "symbol",
        source: {
            data: warehouse,
            type: "geojson",
        },
        layout: {
            "text-field": "Warehouse",
            "text-offset": [0, 1.25],
            "icon-size": 1,
        },
        paint: {
            "text-color": "#3887be",
        },
    });

    map.addLayer({
        id: "dropoffs",
        type: "circle",
        source: {
            data: dropoffs,
            type: "geojson",
        },
        paint: {
            "circle-radius": 9,
            "circle-color": "white",
            "circle-stroke-color": "#3887be",
            "circle-stroke-width": 3,
        },
    });
    map.addLayer({
        id: "dropoffs-symbol",
        type: "symbol",
        source: {
            data: dropoffs,
            type: "geojson",
        },
        layout: {
            "text-field": "{index}",
            "icon-image": "restaurant-15",
            "icon-size": 1,
        },
        paint: {
            "text-color": "#3887be",
        },
    });

    map.addSource("route", {
        type: "geojson",
        data: nothing,
    });

    map.addLayer(
        {
            id: "routeline-active",
            type: "line",
            source: "route",
            layout: {
                "line-join": "round",
                "line-cap": "round",
            },
            paint: {
                "line-color": "#3887be",
                "line-width": [
                    "interpolate",
                    ["linear"],
                    ["zoom"],
                    12,
                    3,
                    22,
                    12,
                ],
            },
        },
        "waterway-label"
    );

    map.addLayer(
        {
            id: "routearrows",
            type: "symbol",
            source: "route",
            layout: {
                "symbol-placement": "line",
                "text-field": "▶",
                "text-size": [
                    "interpolate",
                    ["linear"],
                    ["zoom"],
                    12,
                    24,
                    22,
                    60,
                ],
                "symbol-spacing": [
                    "interpolate",
                    ["linear"],
                    ["zoom"],
                    12,
                    30,
                    22,
                    160,
                ],
                "text-keep-upright": false,
            },
            paint: {
                "text-color": "#3887be",
                "text-halo-color": "hsl(55, 11%, 96%)",
                "text-halo-width": 3,
            },
        },
        "waterway-label"
    );
});

$.ajax({
    url: "/api/store",
    type: "GET",
    dataType: "json",
}).done(function (data) {
    stores = data;
    console.log(stores);
    $(function () {
        $("#dataGrid").dxDataGrid({
            dataSource: stores,
            columns: [
                { dataField: "name", caption: "Store Name" },
                { dataField: "last_survey", caption: "Last Survey" },
                {
                    dataType: "Button",
                    caption: "View",
                    cellTemplate: function (container, options) {
                        return $("<input>")
                            .attr("type", "checkbox")
                            .attr("id", "check_" + options.rowIndex)
                            .attr("name", "check")
                            .attr("value", options.data.id)
                            .addClass("check")
                            .on("change", async function () {
                                if (this.checked) {
                                    await newDropoff(
                                        {
                                            lng: options.data.longitude,
                                            lat: options.data.latitude,
                                        },
                                        options.data.id
                                    );
                                } else {
                                    removeDropoff(options.data.id);
                                }
                            });
                        //give class
                    },
                },
            ],
            selection: { mode: "single" },
            onSelectionChanged: function (e) {
                e.component
                    .byKey(e.currentSelectedRowKeys[0])
                    .done(function (data) {
                        map.flyTo({
                            center: [data.longitude, data.latitude],
                            zoom: 15,
                        });
                    });
            },
        });
    });
    stores.forEach(function (store) {
        addMarker(store.longitude, store.latitude, store.id);
    });
});

function addMarker(lon, lat, id) {
    marker = document.createElement("div");
    marker.className = "store-marker";
    marker.id = "store-marker-" + id;

    marker.addEventListener("click", function (e) {
        console.log("clicked");
    });

    new mapboxgl.Marker(marker).setLngLat([lon, lat]).addTo(map);
}

const flyToStore = (coordinates) => {
    map.flyTo({
        center: coordinates,
        zoom: 15,
    });
};

async function newDropoff(coordinates, id = null) {
    if (id != null) {
        let marker = document.getElementById("store-marker-" + id);
        marker.classList.toggle("hidden");
    }
    lastAtRestaurant = lastAtRestaurant + 75000;
    // Store the clicked point as a new GeoJSON feature with
    // two properties: `orderTime` and `key`
    const pt = turf.point([coordinates.lng, coordinates.lat], {
        orderTime: Date.now(),
        key: id,
        index: dropoffs.features.length + 1,
    });
    dropoffs.features.push(pt);
    pointHopper[pt.properties.key] = pt;
    updateDropoffs(dropoffs);

    createRoute();
}

async function createRoute() {
    // Make a request to the Optimization API
    let newDropoff = turf.featureCollection([]);
    const query = await fetch(assembleQueryURL(), { method: "GET" });
    const response = await query.json();
    response.waypoints.forEach(function (item) {
        const pt = turf.point([item.location[0], item.location[1]], {
            orderTime: Date.now(),
            index: item.waypoint_index,
        });
        newDropoff.features.push(pt);
    });
    updateDropoffs(newDropoff);

    // Create an alert for any requests that return an error
    if (response.code !== "Ok") {
        const handleMessage =
            response.code === "InvalidInput"
                ? "Refresh to start a new route. For more information: https://docs.mapbox.com/api/navigation/optimization/#optimization-api-errors"
                : "Try a different point.";
        alert(`${response.code} - ${response.message}\n\n${handleMessage}`);

        // Remove invalid point
        dropoffs.features.pop();
        delete pointHopper[pt.properties.key];
        return;
    }

    // give number for each store
    let storeNumber = 1;
    response.waypoints.forEach(function (item) {
        item.name = `Store ${storeNumber}`;
        storeNumber++;
    });

    // Create a GeoJSON feature collection
    const routeGeoJSON = turf.featureCollection([
        turf.feature(response.trips[0].geometry),
    ]);

    // Update the `route` source by getting the route source
    // and setting the data equal to routeGeoJSON
    map.getSource("route").setData(routeGeoJSON);
}

function updateDropoffs(geojson) {
    map.getSource("dropoffs").setData(geojson);
    map.getSource("dropoffs-symbol").setData(geojson);
}

// Here you'll specify all the parameters necessary for requesting a response from the Optimization API
function assembleQueryURL() {
    const coordinates = [truckLocation];
    const keepTrack = [truckLocation];

    const restJobs = Object.keys(pointHopper).map((key) => pointHopper[key]);

    if (restJobs.length > 0) {
        for (const job of restJobs) {
            keepTrack.push(job);
            coordinates.push(job.geometry.coordinates);
        }
    }

    return `https://api.mapbox.com/optimized-trips/v1/mapbox/driving/${coordinates.join(
        ";"
    )}?overview=full&steps=true&geometries=geojson&source=first&access_token=${
        mapboxgl.accessToken
    }`;
}

function removeDropoff(key) {
    let marker = document.getElementById("store-marker-" + key);
    marker.classList.toggle("hidden");
    // Remove the point from the `pointHopper` object
    delete pointHopper[key];
    // Remove the point from the `dropoffs.features` array
    const remainingDropoffs = dropoffs.features.filter(function (feature) {
        return feature.properties.key !== Number(key);
    });
    dropoffs.features = remainingDropoffs;
    // Update the `dropoffs-symbol` layer
    map.getSource("dropoffs-symbol").setData(dropoffs);
    // If there are no more points, reset `lastAtRestaurant`
    if (remainingDropoffs.length === 0) lastAtRestaurant = 0;
    // Create a new route
    createRoute();
}

function sendForm() {
    const form = $('form[id="list"]');
    console.log(form.serializeArray());

    const checkboxes = $('input[type="checkbox"]');
    const checked = checkboxes.filter(":checked");
    let checkedValues = [];
    checked.each(function () {
        checkedValues.push($(this).val());
    });

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: {
            survey_id: form.serializeArray()[0].value,
            quality_assurance_team_id: form.serializeArray()[1].value,
            'date': form.serializeArray()[2].value,
            store_ids: checkedValues,
        },
    })
        .done(function (data) {
            createNotification(data.message);
        })
        .fail(function (data) {
            console.log(data);
        });
}

function createNotification(message) {
    const notification = `
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
        <p>${message}</p>
    </div>
    `;
    $("#notification").html(notification);

    setTimeout(function () {
        $("#notification").html("");
    }, 5000);
}
