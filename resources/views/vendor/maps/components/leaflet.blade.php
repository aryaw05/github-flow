<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""/>

<style>
    #{{$mapId}} {
    @if(! isset($attributes['style']))
        height: 100vh;
    @else
        {{ $attributes['style'] }}
    @endif
    }
</style>

<div id="{{$mapId}}" @if(isset($attributes['class']))
 class='{{ $attributes["class"] }}'
@endif
></div>

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="{{'https://unpkg.com/leaflet@' . $leafletVersion . '/dist/leaflet.js'}}"
        crossorigin=""></script>
<script>
    // Batas wilayah Kota Kediri
    var southWest = L.latLng(-7.88, 111.95); // Batas barat daya
    var northEast = L.latLng(-7.75, 112.15); // Batas timur laut
    var bounds = L.latLngBounds(southWest, northEast);

    // Inisialisasi peta dengan maxBounds
    var mymap = L.map('{{$mapId}}', {
        center: [{{$centerPoint['lat'] ?? $centerPoint[0]}}, {{$centerPoint['long'] ?? $centerPoint[1]}}],
        zoom: {{$zoomLevel}},
        maxBounds: bounds, // Batasi area peta
        maxBoundsViscosity: 1.0 ,
         minZoom: 14 
    });

    // Tambahkan tile layer
    @if($tileHost === 'mapbox')
        let url{{$mapId}} = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={{config('maps.mapbox.access_token', null)}}';
    @elseif($tileHost === 'openstreetmap')
        let url{{$mapId}} = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    @else
        let url{{$mapId}} = '{{$tileHost}}';
    @endif
    L.tileLayer(url{{$mapId}}, {
        maxZoom: {{$maxZoomLevel}},
        attribution: '{!! $attribution !!}',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);

    // Tambahkan markers
    @foreach($markers as $marker)
        @if(isset($marker['icon']))
            var icon = L.icon({
                iconUrl: '{{ $marker['icon'] }}',
                iconSize: [{{$marker['iconSizeX'] ?? 32}}, {{ $marker['iconSizeY'] ?? 32 }}],
            });
        @endif
        var marker = L.marker([{{$marker['lat'] ?? $marker[0]}}, {{$marker['long'] ?? $marker[1]}}]
            @if(isset($marker['icon']))
                , {icon: icon}
            @endif
        );
        marker.addTo(mymap);
        @if(isset($marker['info']))
            marker.bindPopup(@json($marker['info']));
        @endif
    @endforeach
</script>
