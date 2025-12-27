<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Baltimore → Los Angeles with Radar Directions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Leaflet CSS -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  />

  <style>
    body { margin: 0; }
    #map { height: 100vh; width: 100%; }
  </style>
</head>
<body>
<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  const RADAR_API_KEY = "prj_live_pk_54b2a02354afc907c3550d5b7e709b61937d9d88";

  const origin = "39.2904,-76.6122";   // Baltimore
  const destination = "34.0522,-118.2437"; // Los Angeles

  const map = L.map("map").setView([39.5, -98.35], 4);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 18,
  }).addTo(map);

  async function fetchDirections() {
    // Use Radar Directions with geometry format=linestring
    const url = `https://api.radar.io/v1/route/directions?locations=${origin}|${destination}&mode=car&geometry=linestring`;

    const res = await fetch(url, {
      headers: { "Authorization": RADAR_API_KEY }
    });

    if (!res.ok) {
      console.error("Radar Directions error", await res.text());
      return;
    }
    return res.json();
  }

  fetchDirections().then(data => {
    if (!data.routes || !data.routes.length) {
      alert("No route found");
      return;
    }

    const route = data.routes[0];
    // route.geometry.coordinates is an array [lng, lat]
    const coords = route.geometry.coordinates.map(c => [c[1], c[0]]);

    const line = L.polyline(coords, { color: "blue", weight: 4 }).addTo(map);
    map.fitBounds(line.getBounds());
  }).catch(err => console.error(err));

</script>
</body>
</html>
