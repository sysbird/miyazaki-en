jQuery(function() {

	// Google Maps
	if( jQuery( '#map-canvas').length ){
		google.maps.event.addDomListener(window, 'load',  myz_google_maps);
	}

	jQuery( window ).load(function() {
		jQuery( ".tile .hentry" ).tile();
		jQuery( '#widget-area .container' ).masonry( 'destroy' );
	} );

	// form
	jQuery( '#zip' ).keyup( function( event ){
		AjaxZip3.zip2addr( this,'','pref','addr' );
	})

	// popup link
	jQuery('a.popup').on('click', function() {
		var pagetitle  = jQuery(this).attr('pagetitle');
		var url = '/wp-json/get_page/' + encodeURIComponent(pagetitle) + '?_jsonp=?';
		jQuery.ajax({
			type: 'GET',
			url: url,
			dataType: 'jsonp'
			}).done(function(data, status, xhr) {

				// popup
				jQuery.magnificPopup.open({
					items: {
						src: '<div  id="content"><div class="entry-title">' + data.title + '</div> ' + data.content +'</div>',
						type: 'inline'
					}
				});

			}).fail(function(xhr, status, error) {
		});

		return false;
	});

});

////////////////////////////////////////
// Google Maps for access
function myz_google_maps() {

	var zoom = 16;
	if( jQuery( 'body.home' ).length){
		zoom = 14;
	}

	var latlng = new google.maps.LatLng( 35.659862, 139.466452 );
	var mapOptions = {
		zoom: zoom,
		center: latlng,
		scrollwheel: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scaleControl: true,
		scaleControlOptions: {
			position: google.maps.ControlPosition.BOTTOM_LEFT
		},
		mapTypeControlOptions: {
			mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'm_map']
		}
	}
	var map = new google.maps.Map( document.getElementById('map-canvas'), mapOptions );

	var map_icon = jQuery( '#map_icon_path' ).val() + '/icon_map.png' ;
	var myzMarker = new google.maps.Marker({
		position: latlng,
		map: map,
		icon: map_icon
	});


    new google.maps.InfoWindow({
        content: '宮﨑園<br><a href="https://goo.gl/maps/eaKy3dJ3LNo" style="display :block;padding-top: 5px; font-size: 0.9em;" target="_blank">地図を拡大表示</a>'
    }).open(myzMarker.getMap(), myzMarker);

}
