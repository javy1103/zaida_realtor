
    <script type="text/javascript">

        function initializePropertiesMap(mapData) {

            /* Properties Array */
            var properties = mapData;

            /* Map Center Location - From Theme Options */
            var location_center = new google.maps.LatLng(properties[0].lat,properties[0].lng);

            var mapOptions = {
                zoom: 12,
                maxZoom: 16,
                scrollwheel: false
            }

            var map = new google.maps.Map(document.getElementById("listing-map"), mapOptions);

            var bounds = new google.maps.LatLngBounds();

            /* Loop to generate marker and infowindow based on properties array */
            var markers = new Array();
            var info_windows = new Array();

            for (var i=0; i < properties.length; i++) {

                markers[i] = new google.maps.Marker({
                    position: new google.maps.LatLng(properties[i].lat,properties[i].lng),
                    map: map,
                    icon: properties[i].icon,
                    title: properties[i].title,
                    animation: google.maps.Animation.DROP,
                    visible: true
                });

                bounds.extend(markers[i].getPosition());

                var boxText = document.createElement("div");
                boxText.className = 'map-info-window';
                boxText.innerHTML = '<a class="thumb-link" href="'+properties[i].url+'">' +
                                        '<img class="prop-thumb" src="'+properties[i].thumb+'" alt="'+properties[i].title+'"/>' +
                                    '</a>' +
                                    '<h5 class="prop-title"><a class="title-link" href="'+properties[i].url+'">'+properties[i].title+'</a></h5>' +
                                    '<p><span class="price">'+properties[i].price+'</span></p>'+
                                    '<div class="arrow-down"></div>';


                var myOptions = {
                    content: boxText,
                    disableAutoPan: true,
                    maxWidth: 0,
                    alignBottom: true,
                    pixelOffset: new google.maps.Size( -122, -48 ),
                    zIndex: null,
                    closeBoxMargin: "0 0 -16px -16px",
                    closeBoxURL: "<?php echo get_template_directory_uri() . '/images/map/close.png'; ?>",
                    infoBoxClearance: new google.maps.Size( 1, 1 ),
                    isHidden: false,
                    pane: "floatPane",
                    enableEventPropagation: false
                };

                var ib = new InfoBox( myOptions );

                attachInfoBoxToMarker( map, markers[i], ib );
            }

            map.fitBounds(bounds);

            /* Marker Clusters */
            var markerClustererOptions = {
                ignoreHidden: true,
                maxZoom: 14,
                styles: [{
                    textColor: '#ffffff',
                    url: "<?php echo get_template_directory_uri() . '/images/map/cluster-icon.png'; ?>",
                    height: 48,
                    width: 48
                }]
            };

            var markerClusterer = new MarkerClusterer( map, markers, markerClustererOptions );

            function attachInfoBoxToMarker( map, marker, infoBox ){
                google.maps.event.addListener( marker, 'click', function(){
                    var scale = Math.pow( 2, map.getZoom() );
                    var offsety = ( (100/scale) || 0 );
                    var projection = map.getProjection();
                    var markerPosition = marker.getPosition();
                    var markerScreenPosition = projection.fromLatLngToPoint( markerPosition );
                    var pointHalfScreenAbove = new google.maps.Point( markerScreenPosition.x, markerScreenPosition.y - offsety );
                    var aboveMarkerLatLng = projection.fromPointToLatLng( pointHalfScreenAbove );
                    map.setCenter( aboveMarkerLatLng );
                    infoBox.open( map, marker );
                });
            }
        }

        

    </script>

    <div id="map-head">
        <div id="listing-map"></div>
    </div>
    <!-- End Map Head -->