@extends('website.layout.app',['footer_visible'=> true])
@section('content')
<br>
<form action="{{route('submit.savedmap',['type'=>$type])}}" method="post">
    @csrf
    @method('POST')
    <input type="hidden" name="lat" id="lat">
    <input type="hidden" name="lng" id="lng">
    {{-- ama asretawa --}}
    <div class="container">
        <div class="row" style="position: relative;">
            <div class="input-field col s9 right right-align" style="margin: 0;">
                <label class="active" style="position:inherit;">ناوی تەواو</label>
                <input type="text" name="name" class="validate">
            </div>
            <button style="position: absolute;width: 25%;bottom: 11px;"
                class="waves-effect waves-light pink lighten-3 white-text btn" type="submit">هەڵگرتن</button>
        </div>
    </div>
</form>
<div id="map"></div>
{{-- footer lam page'a nabe betawa --}}

<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.css' rel='stylesheet' />
<style>
</style>

<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js'></script>
<link rel='stylesheet'
    href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.css'
    type='text/css' />

<script>
    //var saved_markers =  get_saved_locations() ;
    var latitude = 35.5618002;
    var longitude  = 45.4283688;
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert('not supported');
        }
        }
        function showPosition(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
        }
        
    var user_location = [longitude,latitude];
    mapboxgl.accessToken = 'pk.eyJ1IjoiZmFraHJhd3kiLCJhIjoiY2pscWs4OTNrMmd5ZTNra21iZmRvdTFkOCJ9.15TZ2NtGk_AtUvLd27-8xA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v9',
        center: user_location,
        zoom: 15    
    });
    //  geocoder here
    var geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        // limit results to Australia
        //country: 'IN',
    });

    var marker ;

    // After the map style has loaded on the page, add a source layer and default
    // styling for a single point.
    map.on('load', function() {
        getLocation();
        addMarker(user_location,'load');
        marker.setLngLat(user_location);
        document.getElementById("lat").value = latitude;
        document.getElementById("lng").value = longitude;
        //add_markers(saved_markers);

        // Listen for the `result` event from the MapboxGeocoder that is triggered when a user
        // makes a selection and add a symbol that matches the result.
        geocoder.on('result', function(ev) {
            

        });
    });
    map.on('click', function (e) {
        marker.remove();
        addMarker(e.lngLat,'click');
        //console.log(e.lngLat.lat);
        document.getElementById("lat").value = e.lngLat.lat;
        document.getElementById("lng").value = e.lngLat.lng;

    });

    function addMarker(ltlng,event) {

        if(event === 'click'){
            user_location = ltlng;
        }
        marker = new mapboxgl.Marker({draggable: true,color:"#d02922"})
            .setLngLat(user_location)
            .addTo(map)
            .on('dragend', onDragEnd);
    }
    function add_markers(coordinates) {

        //var geojson = (saved_markers == coordinates ? saved_markers : '');

        console.log(geojson);
        // add markers to map
        geojson.forEach(function (marker) {
            
            // make a marker for each feature and add to the map
            new mapboxgl.Marker()
                .setLngLat(marker)
                .addTo(map);
        });

    }

    function onDragEnd() {
        var lngLat = marker.getLngLat();
        document.getElementById("lat").value = lngLat.lat;
        document.getElementById("lng").value = lngLat.lng;
        console.log('lng: ' + lngLat.lng + '<br />lat: ' + lngLat.lat);
    }
    document.getElementsByClassName('mapboxgl-ctrl-bottom-right')[0].remove();
    document.getElementsByClassName('mapboxgl-ctrl-bottom-left')[0].remove();

</script>

@endsection