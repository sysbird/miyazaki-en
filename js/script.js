jQuery(function() {

	// vagetables card
/*
	jQuery('.tile .type-vegetables a').live("click",function(){
		var id  = jQuery(this).parents( '.type-vegetables' ).attr('id');
		id = id.replace( 'post-', '' );
		var url = '/wp-json/get_vegetables/' + id + '?_jsonp=?';
		jQuery.ajax({
			type: 'GET',
			url: url,
			dataType: 'jsonp'
			}).done(function(data, status, xhr) {

				// popup
				jQuery.magnificPopup.open({
					items: {
						src: '<div class="vegetables_card"><div class="entry-title">' + data.title + '</div> ' + data.content +'</div>',
						type: 'inline'
					}
				});

			}).fail(function(xhr, status, error) {
		});

		return false;
	});
*/

	// Google Maps
	if( jQuery( '#map-canvas').length ){
		google.maps.event.addDomListener(window, 'load',  myz_google_maps);
	}

	jQuery( window ).load(function() {
		jQuery( ".home .tile .type-fruits" ).tile();

		jQuery( ".fruit .tile .type-fruits" ).tile();

		jQuery( '.tile.masonry ' ).masonry({
			itemSelector: '.type-fruits',
			isAnimated: true
		});

		// for facebook
		jQuery( '#widget-area .container' ).masonry( 'destroy' );
		var widgetArea = jQuery( '#widget-area' ).height();
		var footerHeight = jQuery( '#footer .site-title' ).innerHeight();
		var height = parseInt( widgetArea ) + parseInt( footerHeight );
		jQuery('#content').css('padding-bottom', height + 'px' );
		jQuery('#footer').css('height', height + 'px' );

	} );
});

////////////////////////////////////////
// Google Maps for access
function myz_google_maps() {

	var latlng = new google.maps.LatLng( 35.659862, 139.466452 );
	var mapOptions = {
		zoom: 16,
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

//	var map_icon = jQuery( '#map_icon_path' ).val() + '/icon_shop.png' ;
	var myzMarker = new google.maps.Marker({
		position: latlng,
		map: map,
//		icon: map_icon
	});


    new google.maps.InfoWindow({
        content: '宮崎園<br><a href="https://goo.gl/maps/eaKy3dJ3LNo" style="display :block;padding-top: 5px; font-size: 0.9em;" target="_blank">地図を拡大表示</a>'
    }).open(myzMarker.getMap(), myzMarker);

}
