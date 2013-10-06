var line = new Array();

function initmap(coordinates){
  	var mapOptions = {
          center: new google.maps.LatLng(coordinates[0], coordinates[1]),
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

    var map = new google.maps.Map(document.getElementById("map_canvas_mid"), mapOptions);
    return map;
}

function addmarker(map, coordinates, str){
	var myLatlng = new google.maps.LatLng(coordinates[0], coordinates[1]);

	var infowindow = new google.maps.InfoWindow({
		content: str,
		maxWidth: 500
	});

	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: coordinates[0] +', '+ coordinates[1]
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map, marker);
	});
}

function addline(map, cor_start, cor_stop){
 var lineCoordinates = [
    new google.maps.LatLng(cor_start[0], cor_start[1]),
    new google.maps.LatLng(cor_stop[0], cor_stop[1])
  ];

  // Define the symbol, using one of the predefined paths ('CIRCLE')
  // supplied by the Google Maps JavaScript API.
  var lineSymbol = {
    path: google.maps.SymbolPath.CIRCLE,
    scale: 8,
    strokeColor: '#393'
  };

  // Create the polyline and add the symbol to it via the 'icons' property.
  line_tmp = new google.maps.Polyline({
    path: lineCoordinates,
    icons: [{
      icon: lineSymbol,
      offset: '100%'
    }],
    map: map
  });
  line.push(line_tmp);

  animateCircle();
}

// Use the DOM setInterval() function to change the offset of the symbol
// at fixed intervals.
function animateCircle() {
    var count = 0;
    window.setInterval(function() {
      count = (count + 1) % 200;

      var i;
      for(i = 0; i< line.length; i++)
      {
        var icons = line[i].get('icons');
        icons[0].offset = (count / 2) + '%';
        line[i].set('icons', icons);
      }
	  }, 20);
}