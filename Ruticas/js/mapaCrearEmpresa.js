
navigator.geolocation.getCurrentPosition(
	function(location) {
		var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
		var actualPos = L.icon({
			iconUrl: 'img/actualPos.png',
			iconSize: [25, 45]
		});

		var map = L.map('map').setView(latlng, 13)
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://mapbox.com">Mapbox</a>',
		maxZoom: 18,
		id: 'mapbox.streets',
		accessToken: 'pk.eyJ1IjoiYmJyb29rMTU0IiwiYSI6ImNpcXN3dnJrdDAwMGNmd250bjhvZXpnbWsifQ.Nf9Zkfchos577IanoKMoYQ'
		}).addTo(map);
		var customOptions = {'maxWidth': '2000', 'className': 'custom'};
		var marker = L.marker(latlng, {icon: actualPos, title:"Usted está aquí"}).bindPopup("Usted está aquí", customOptions).addTo(map);
		L.control.scale().addTo(map);
		
		var popup = L.popup();
		function onMapClick(e) {
			document.getElementById('latitud').value =  e.latlng.lat ;
			document.getElementById('longitud').value =  e.latlng.lng ;
			popup
				.setLatLng(e.latlng)
				.setContent("Posición de la empresa <br>Latitud: " + e.latlng.lat + "<br>Longitud: "+  e.latlng.lng )
				.openOn(map);
		}
		map.on('click', onMapClick);	
	}
);




