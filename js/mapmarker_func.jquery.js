		//set up markers 
		var myMarkers = {"markers": [
				{"latitude": "23.8017428", "longitude":"90.3582814", "icon": "img/map-marker2.png"}
			]
		};
		
		//set up map options
		$("#map").mapmarker({
			zoom	: 13,
			center	: 'bibm dhaka',
			markers	: myMarkers
		});
	