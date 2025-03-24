<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>MAP</h1>
<x-maps-leaflet
    :centerPoint="['lat'  => -7.89239, 'long' => 112.0119]"
    :zoomLevel="12"
    :options="[
        'maxBounds' => [
            ['lat' => -7.88, 'long' => 111.95], // Batas barat daya
            ['lat' => -7.75, 'long' => 112.15],  // Batas timur laut
        ],
        'maxBoundsViscosity' => 1.0, // Memastikan peta tidak bisa digeser keluar bounds
    ]"
    :markers="[['lat' => -7.8239, 'long' => 112.0119]]"
></x-maps-leaflet>
<div>
    <h1>aryaaa</h1>
</div>
</body>
</html>