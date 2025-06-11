<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/reverse-geocode', function (Request $request) {
$request->validate([
'lat' => 'required|numeric',
'lon' => 'required|numeric'
]);

$response = Http::withHeaders([
'User-Agent' => 'YourAppName/1.0 (your@email.com)'
])->get('https://nominatim.openstreetmap.org/reverse', [
'format' => 'json',
'lat' => $request->lat,
'lon' => $request->lon,
'zoom' => 18,
'addressdetails' => 1
]);

return $response->json();
});

Route::get('/geocode', function (Request $request) {
$request->validate([
'q' => 'required|string|min:3'
]);

$response = Http::withHeaders([
'User-Agent' => 'YourAppName/1.0 (your@email.com)'
])->get('https://nominatim.openstreetmap.org/search', [
'format' => 'json',
'q' => $request->q,
'limit' => 1,
'addressdetails' => 1
]);

return $response->json();
});


