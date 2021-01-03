(function($){
var body = 'body.single';
$('.st-map-box', body).each(function () {
        var parent = $(this),
        mapEl = $('.google-map-mapbox', parent);
        mapboxgl.accessToken = st_params.token_mapbox;
        if(typeof st_params.text_rtl_mapbox !== 'underfind' ){
            mapboxgl.setRTLTextPlugin(st_params.text_rtl_mapbox);
        }
        /* Map: This represents the map on the page. */
        var map = new mapboxgl.Map({
            container: "st-map",
            style: "mapbox://styles/mapbox/streets-v11?optimize=true",
            zoom: mapEl.data().zoom,
            center: [ mapEl.data().lng,mapEl.data().lat]
        });
        var icon_hotel = st_params.st_icon_mapbox;
            if(typeof icon_hotel !== 'underfind' ){
                icon_map = icon_hotel;
            } else {
                icon_map = "https://i.imgur.com/MK4NUzI.png";
            }

        map.on("load", function() {
            map.resize();
            /* Image: An image is loaded and added to the map. */
            map.loadImage(icon_hotel, function(error, image) {
                if (error) throw error;
                map.addImage("custom-marker", image);
                /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                map.addLayer({
                    id: "markers",
                    type: "symbol",
                    /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
                    source: {
                        type: "geojson",
                        data: {
                            type: 'FeatureCollection',
                            features: [{
                                type: 'Feature',
                                properties: {},
                                geometry: {
                                    type: "Point",
                                    coordinates: [ mapEl.data().lng,mapEl.data().lat]
                                }
                            }]
                        }
                    },
                    layout: {
                        "icon-image": "custom-marker",
                    }
                });
            });
        });

        /*Resize map after popup modal*/
        $('#st-modal-show-map').on('shown.bs.modal', function () { // chooseLocation is the id of the modal.
            map.resize();
        });
    });


    /*Elemenent ST MapBox*/
    function initMapContactPage(mapEl) {
        var mapLat = mapEl.data('lat');
        var mapLng = mapEl.data('lng');
        mapboxgl.accessToken = st_params.token_mapbox;
        /* Map: This represents the map on the page. */
        var map = new mapboxgl.Map({
            container: "contact-mapbox-new",
            style: "mapbox://styles/mapbox/streets-v11?optimize=true",
            zoom: 13,
            center: [mapLng,mapLat]
        });

        map.on("load", function() {
            /* Image: An image is loaded and added to the map. */
            map.loadImage("https://i.imgur.com/MK4NUzI.png", function(error, image) {
                if (error) throw error;
                map.addImage("custom-marker", image);
                /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
                map.addLayer({
                    id: "markers",
                    type: "symbol",
                    /* Source: A data source specifies the geographic coordinate where the image marker gets placed. */
                    source: {
                        type: "geojson",
                        data: {
                            type: 'FeatureCollection',
                            features: [{
                                type: 'Feature',
                                properties: {},
                                geometry: {
                                    type: "Point",
                                    coordinates: [mapLng,mapLat]
                                }
                            }]
                        }
                    },
                    layout: {
                        "icon-image": "custom-marker",
                    }
                });
            });
            var mapCanvas = document.getElementsByClassName('mapboxgl-canvas')[0];
            mapCanvas.style.width = '100%';
            mapCanvas.style.height = '500px';
            map.resize();
        });

        /*Resize map after popup modal*/
        // $('#st-modal-show-map').on('shown.bs.modal', function () { // chooseLocation is the id of the modal.
        //     map.resize();
        // });
    }
    if ($('#contact-mapbox-new').length) {

        initMapContactPage($('#contact-mapbox-new'));
    }

})(jQuery);
