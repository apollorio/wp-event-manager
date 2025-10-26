/* wpem-leaflet.js
 * Frontend geocoding (Nominatim) and Leaflet map preview for WP Event Manager
 */
(function($){
    'use strict';

    function initMap(lat, lng, containerId){
        try {
            if(!lat || !lng) return null;
            var mapEl = document.getElementById(containerId);
            if(!mapEl) return null;
            mapEl.style.display = 'block';
            // avoid reinitializing multiple times
            if(mapEl._leaflet_map) {
                mapEl._leaflet_map.setView([lat, lng], 13);
                if(mapEl._leaflet_marker) {
                    mapEl._leaflet_marker.setLatLng([lat, lng]);
                } else {
                    mapEl._leaflet_marker = L.marker([lat, lng]).addTo(mapEl._leaflet_map);
                }
                return mapEl._leaflet_map;
            }
            var map = L.map(containerId).setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);
            var marker = L.marker([lat, lng]).addTo(map);
            mapEl._leaflet_map = map;
            mapEl._leaflet_marker = marker;
            return map;
        } catch (e) {
            console.error(e);
            return null;
        }
    }

    function geocode(address, cb){
        if(!address) { cb(null); return; }
        var url = wpem_leaflet_params && wpem_leaflet_params.nominatim_url ? wpem_leaflet_params.nominatim_url : 'https://nominatim.openstreetmap.org/search';
        url += '?format=json&limit=1&q=' + encodeURIComponent(address);
        // Nominatim requires a proper User-Agent; browsers will send one.
        fetch(url, { method: 'GET', headers: { 'Accept': 'application/json' } })
            .then(function(r){ return r.json(); })
            .then(function(data){
                if(data && data.length) {
                    var item = data[0];
                    cb({ lat: item.lat, lon: item.lon, display_name: item.display_name, raw: item });
                } else {
                    cb(null);
                }
            }).catch(function(){ cb(null); });
    }

    $(document).ready(function(){
        // Handle single event page map display
        var $eventMap = $('#wpem-event-map');
        if($eventMap.length) {
            // Try to get coordinates from hidden inputs or data attributes
            var lat = $eventMap.data('lat') || $('#geolocation_lat').val();
            var lon = $eventMap.data('lon') || $('#geolocation_long').val();

            if(lat && lon) {
                initMap(parseFloat(lat), parseFloat(lon), 'wpem-event-map');
            } else {
                // Try to geocode from the displayed location text
                var $locationText = $('.wpem-event-location, .event-location').first();
                if($locationText.length && $locationText.text().trim()) {
                    geocode($locationText.text().trim(), function(res){
                        if(res) {
                            initMap(parseFloat(res.lat), parseFloat(res.lon), 'wpem-event-map');
                        }
                    });
                }
            }
        }

        var $form = $('#submit-event-form');
        if(!$form.length) return;

        // helper to ensure hidden inputs exist
        function ensureInputs(){
            if($('#geolocation_lat').length === 0) {
                $form.append('<input type="hidden" id="geolocation_lat" name="geolocation_lat" value="" />');
            }
            if($('#geolocation_long').length === 0) {
                $form.append('<input type="hidden" id="geolocation_long" name="geolocation_long" value="" />');
            }
            if($('#geolocation_formatted_address').length === 0) {
                $form.append('<input type="hidden" id="geolocation_formatted_address" name="geolocation_formatted_address" value="" />');
            }
            if($('#geolocated').length === 0) {
                $form.append('<input type="hidden" id="geolocated" name="geolocated" value="" />');
            }
        }
        ensureInputs();

        var $address = $form.find('input[name="event_location"], input#event_location, input[name="_event_location"]').first();
        if(!$address.length) return;

        function updateMapFromInputs(){
            var lat = $('#geolocation_lat').val();
            var lon = $('#geolocation_long').val();
            if(lat && lon) {
                initMap(parseFloat(lat), parseFloat(lon), 'wpem-map');
            }
        }

        // initialize map if values present
        updateMapFromInputs();

        var timeout = null;
        $address.on('input', function(){
            clearTimeout(timeout);
            timeout = setTimeout(function(){
                var val = $address.val();
                if(!val) return;
                geocode(val, function(res){
                    if(res) {
                        $('#geolocation_lat').val(res.lat);
                        $('#geolocation_long').val(res.lon);
                        $('#geolocation_formatted_address').val(res.display_name);
                        $('#geolocated').val(1);
                        initMap(parseFloat(res.lat), parseFloat(res.lon), 'wpem-map');
                    }
                });
            }, 650);
        });

        // Also geocode on blur
        $address.on('blur', function(){
            var val = $address.val();
            if(!val) return;
            geocode(val, function(res){
                if(res) {
                    $('#geolocation_lat').val(res.lat);
                    $('#geolocation_long').val(res.lon);
                    $('#geolocation_formatted_address').val(res.display_name);
                    $('#geolocated').val(1);
                    initMap(parseFloat(res.lat), parseFloat(res.lon), 'wpem-map');
                }
            });
        });
    });
})(jQuery);
