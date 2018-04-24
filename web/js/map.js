
function initMapOnLoad() {
    /* map */
    // Asynchronously Load the map API
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyDBPH_wUZCQhMcfE1xEhALZzPQslMngLTg&sensor=false&callback=initialize";
    document.body.appendChild(script);
}

/*map*/
function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap',
        styles: [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#e88b24"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#dadada"
                    },
                    {
                        "weight": "1.00"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.landcover",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#f0f0f0"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.terrain",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#f0f0f0"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#f0f0f0"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#e88b24"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#f0f0f0"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#f0f0f0"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#6e6f71"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#d9d9d9"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#6e6f71"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#6e6f71"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#e88b24"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#fafafa"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#6e6f71"
                    }
                ]
            }
        ],
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_BOTTOM
        },
        mapTypeControl: false,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.LEFT_BOTTOM
        }
    };

    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

    // Multiple Markers
    var markers = [
        ['г. Киев, ул. Пшеничная 8', 50.425987,30.4020535],
        ['г. Днепр, ул. Рабочая 8Б', 48.466228,35.00772],
        ['г. Донецк, ул. Сеченова 3А', 47.998794,37.8558855],
        ['г. Харьков, ул. Большая Гончаровская 32А', 49.9802125,36.2051899],
        ['г. Суммы, ул. Замостянская 38А', 50.9007105,34.8298655],
        ['г. Ивано-Франковск, ул. Максимовича 15', 48.9424495,24.7270597],
        ['г. Коломыя, ул. Пекарская 6, Ивано-Франковская обл.', 48.5390665,24.9807159],
        ['г. Львов, ул. Промышленная 50/52', 49.8625165,24.0446278],
        ['г. Одесса, ул. Бугаевская 54/1', 46.471508,30.695299],
        ['г. Ровно, ул. Киевская 92А', 50.6128315,26.3069218],
        ['г. Запорожье, ул. Украинская 143', 47.8347905,35.174815],
        ['г. Житомир, ул. Киевская 83/1', 50.2613654,28.6700942],
        ['г. Кировоград, ул. А.Тарковского 76/3', 48.5048902,32.2643439],
        ['г. Херсон, шоссе Новониколаевское 7А', 46.6604455,32.5897354],
        ['г. Киев, ул. Красноткацкая 42Д', 50.4580796,30.6422071],
        // ['Palace of Westminster, London', 51.499633,-0.124755]
    ];

    // Info Window Content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h3>Украина, г. Киев, ул. Пшенична, 8</h3>' +
        '<p>(+380 44) 594-19-45<br>(+380 67) 708-88-13<br><br>info@colormarket.ua</p>' +        '</div>'],
        ['<div class="info_content">' +
        '<h3>Palace of Westminster</h3>' +
        '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
        '</div>']
    ];

    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

    // Loop through our array of markers & place each one on the map
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);

        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });

        marker.setIcon('/img/main/marker.png')
        bounds.extend(position);
        console.log(bounds);
        // Allow each marker to have an info window
        // google.maps.event.addListener(marker, 'click', (function(marker, i) {
        //     return function() {
        //         infoWindow.setContent(infoWindowContent[i][0]);
        //         infoWindow.open(map, marker);
        //     }
        // })(marker, i));

        // Automatically center the map fitting all markers on the screen
    }

    map.fitBounds(bounds);

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    // var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
    //     this.setZoom(12);
    //     google.maps.event.removeListener(boundsListener);
    // });

}
initMapOnLoad();