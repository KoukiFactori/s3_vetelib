var map = L.map('map').setView([49.12578030153661, 6.226922203992883], 15);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([49.12578030153661, 6.226922203992883]).addTo(map);