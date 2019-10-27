function recargar(){
   // document.getElementById("map").style = ".leaflet-control-container .leaflet-routing-container-hide {     display: none; }";
    // mapsPlaceholder[0].removeControl(routingControl);
    // map.removeControl(routingControl);
    //routingControl.hide();
    // document.getElementsByClassName("leaflet-routing-container-hide")[0].style.setProperty('display', 'none');
    // document.getElementsByClassName("leaflet-control-container")[0].style.setProperty('display', 'none');
    // routingControl.hide();
    // routingControl = L.Routing.control({
	// 	waypoints: waypoints, draggableWaypoints: false, show:false
	// }).addTo(mapsPlaceholder[0]);
    nombres = new Array();
    marker = new Array();
    dibujarRuta();
    //routingControl = null;
}