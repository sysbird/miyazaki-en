<?php
add_filter( 'comments_open', '__return_false' );

//////////////////////////////////////////////////////
// Setup Theme
function miyazaki_en_setup() {

	register_default_headers( array(
		'birdfield_child'		=> array(
		'url'			=> '%2$s/images/header.jpg',
		'thumbnail_url'		=> '%2$s/images/header-thumbnail.jpg',
		'description_child'	=> 'birdfield'
		)
	) );
}
add_action( 'after_setup_theme', 'miyazaki_en_setup' );

//////////////////////////////////////////////////////
// Child Theme Initialize
function miyazaki_en_init() {

 	// add tags at page
	register_taxonomy_for_object_type('post_tag', 'page');
	// add post type news
	$labels = array(
		'name'		=> 'お知らせ',
		'all_items'	=> 'お知らせの一覧',
		);
	$args = array(
		'labels'			=> $labels,
		'supports'		=> array( 'title','editor', 'thumbnail' ),
		'public'			=> true,	// 公開するかどうが
		'show_ui'		=> true,	// メニューに表示するかどうか
		'menu_position'	=> 5,		// メニューの表示位置
		'has_archive'		=> true,	// アーカイブページの作成
		);
	register_post_type( 'news', $args );

	// add post type fruits
	$labels = array(
		'name'		=> 'くだもの・野菜',
		'all_items'	=> 'くだもの・野菜一覧',
		);

	$args = array(
		'labels'			=> $labels,
		'supports'		=> array( 'title','editor', 'thumbnail', 'custom-fields' ),
		'public'			=> true,	// 公開するかどうが
		'show_ui'		=> true,	// メニューに表示するかどうか
		'menu_position'	=> 5,		// メニューの表示位置
		'has_archive'		=> true,	// アーカイブページの作成
		);

	register_post_type( 'fruits', $args );

	// add post type sweets
	$labels = array(
		'name'		=> '焼き菓子',
		'all_items'	=> '焼き菓子の一覧',
		);

	$args = array(
		'labels'			=> $labels,
		'supports'		=> array( 'title','editor', 'thumbnail', 'custom-fields' ),
		'public'			=> true,	// 公開するかどうが
		'show_ui'		=> true,	// メニューに表示するかどうか
		'menu_position'	=> 5,		// メニューの表示位置
		'has_archive'		=> true,	// アーカイブページの作成
		);

	register_post_type( 'sweets', $args );

	// add permalink rule for fruits
	add_rewrite_rule('fruits/type/([a-zA-Z_]+)/?$' ,'index.php?post_type=fruits&type=$matches[1]', 'top');
	add_rewrite_rule('fruits/season/([a-zA-Z_]+)/?$' ,'index.php?post_type=fruits&season=$matches[1]', 'top');
}
add_action( 'init', 'miyazaki_en_init', 0 );

//////////////////////////////////////////////////////
// Filter at main query
function miyazaki_en_query( $query ) {

 	if ( $query->is_home() && $query->is_main_query() ) {
 		// toppage news
		$query->set( 'post_type', 'news' );
		$query->set( 'posts_per_page', 3 );
	}

	if ($query->is_main_query() && is_post_type_archive('fruits')) {
		// fruits
		$type = get_query_var('type') ;
		if( !empty( $type )){
			// fruits type
			$query->set('meta_query',
				array(
					array(
					'key' => 'type',
					'value' => $type,
					'compare' => 'LIKE' )));
			$query->set( 'posts_per_page', -1 );
		}
		else {
			$season = get_query_var('season') ;
			if( !empty( $season )){
				// fruits season
				$query->set('meta_query',
					array(
						array(
						'key' => 'season',
						'value' => $season,
						'compare' => 'LIKE' )));
				$query->set( 'posts_per_page', -1 );
			}
		}
	}
}
add_action( 'pre_get_posts', 'miyazaki_en_query' );

//////////////////////////////////////////////////////
// Enqueue Scripts
function miyazaki_en_scripts() {

	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

	if ( is_page() || is_home() ) {
		wp_enqueue_script( 'googlemaps', '//maps.googleapis.com/maps/api/js?key=AIzaSyCEFPK8jnSbZX82eWyq8KGSDdttomacAIU');
	}

	wp_enqueue_script( 'miyazaki_en', get_stylesheet_directory_uri() .'/js/script.js', array( 'jquery' , 'birdfield' ), '1.00');
}
add_action( 'wp_enqueue_scripts', 'miyazaki_en_scripts' );

//////////////////////////////////////////////////////
// Shortcode Goole Maps
function miyazaki_en_map ( $atts ) {

	$output = '<div id="map-canvas">地図はいります </div>';
	$output .= '<input type="hidden" id="map_icon_path" value="' .get_stylesheet_directory_uri() .'/images">';
	return $output;
}
add_shortcode( 'miyazaki_en_map', 'miyazaki_en_map' );

//////////////////////////////////////////////////////
// Shortcode Vegitables Calendar
function miyazaki_en_fruits_calendar ( $atts ) {

	extract( shortcode_atts( array(
		'title' => 'no'
		), $atts ) );

	$html_table_header = '<table class="fruits-calendar"><tbody><tr><th class="title">&nbsp;</th><th class="data"><span>1月</span><span>2月</span><span>3月</span><span>4月</span><span>5月</span><span>6月</span><span>7月</span><span>8月</span><span>9月</span><span>10月</span><span>11月</span><span>12月</span></th></tr>';
	$html_table_footer = '</tbody></table>';
	$html = '';

	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'fruits',
		'post_status' => 'publish',
	);

	$the_query = new WP_Query($args);
	$type_current = '';
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();

		$type = get_field( 'type' );
		if( $type && ( $type != $type_current ) ){
			if( !empty( $html )){
				$html .= $html_table_footer;
			}

			$html .= '<div class="fruits-meta">' .miyazaki_en_get_type_label( $type ) .'</div>';
			$type_current = $type;
			$html .= $html_table_header;
		}

		// 収穫カレンダー
		$selected = get_field( 'calendar' );
		$html .= '<tr>';
		$html .= '<td class="title"><a href="' .get_permalink() .'">' .get_the_title() .'</a></td>';
		$html .= '<td class="data">';
		for( $i = 1; $i <= 12; $i++ ){
			if( in_array( $i, $selected) ) {
				$html .= '<span class="best">' .$i .'</span>';
			}
			else{
				$html .= '<span>' .$i .'</span>';
			}
		}

		$html .= '</td>';
		$html .= '</tr>';

		endwhile;

		wp_reset_postdata();
	endif;


	if( !empty( $html )){
		$html .= $html_table_footer;
	}

	if( 'yes' === $title ){
		$html = '<h2>野菜収穫カレンダー</h2>' .$html;
	}

	return $html;
}
add_shortcode( 'miyazaki_en_fruits_calendar', 'miyazaki_en_fruits_calendar' );

//////////////////////////////////////////////////////
// Shortcode Vegitables Pickup at home
function miyazaki_en_fruits_pickup ( $atts ) {
	ob_start();

	$args = array(
		'posts_per_page' => 6,
		'post_type' => 'fruits',
		'post_status' => 'publish',
		'meta_key' => '_thumbnail_id',
		'orderby'	 => 'rand',
	);

	$the_query = new WP_Query($args);
	if ( $the_query->have_posts() ) :
		?> <div class="tile"><?php

		while ( $the_query->have_posts() ) : $the_query->the_post();
			get_template_part( 'content', 'fruits' );
		endwhile;

		?></div><?php

		wp_reset_postdata();
	endif;

	return ob_get_clean();
}
add_shortcode( 'miyazaki_en_fruits_pickup', 'miyazaki_en_fruits_pickup' );

//////////////////////////////////////////////////////
// Shortcode Swieets Pricekist
function miyazaki_en_swieets_pricekist ( $atts ) {
}
add_shortcode( 'miyazaki_en_swieets_pricekist', 'miyazaki_en_swieets_pricekist' );

//////////////////////////////////////////////////////
// Display the Featured Image at vegetable page
function miyazaki_en_post_image_html( $html, $post_id, $post_image_id ) {

	if( !( false === strpos( $html, 'anchor' ) ) ){
		$html = '<a href="' .get_permalink() .'" class="thumbnail">' .$html .'</a>';
	}

	return $html;
}
add_filter( 'post_thumbnail_html', 'miyazaki_en_post_image_html', 10, 3 );

/////////////////////////////////////////////////////
// get type label in fruits
function miyazaki_en_get_type_label( $value, $anchor = TRUE ) {
	$label ='';
	$fields = get_field_object( 'type' );
	$url = get_post_type_archive_link( 'fruits' );

	if( array_key_exists( 'choices' , $fields ) ){
		$label .= '<span>';
		if( $anchor ){
//			$label .= '<a href="' .$url .'type/' .$value .'">';
		}
		$label .= $fields[ 'choices' ][ $value ];
		if( $anchor ){
//			$label .= '</a>';
		}
		$label .= '</span>';
	}

	return $label;
}

/////////////////////////////////////////////////////
// get season label in fruits
function miyazaki_en_get_season_label( $value, $anchor = TRUE ) {
	$label ='';
	$fields = get_field_object( 'season' );
	$url = get_post_type_archive_link( 'fruits' );

	if( is_array($value)){
		foreach ( $value as $key => $v ) {
			if( array_key_exists( 'choices', $fields) ) {
				$label .= '<span>';
				if( $anchor ){
					$label .= '<a href="' .$url .'season/' .$v .'">';
				}
				$label .= ( $fields[ 'choices' ][ $v ] );
				if( $anchor ){
					$label .= '</a>';
				}
				$label .= '</span>';
			}
		}
	}
	else{
		if( array_key_exists( 'choices', $fields) ) {
			$label .= '<span>'. $fields[ 'choices' ][ $value ] .'</span>';
		}
	}

	return $label;
}

/////////////////////////////////////////////////////
// add permalink parameters for fruits
function miyazaki_en_query_vars( $vars ){
	$vars[] = "type";
	$vars[] = "season";
	return $vars;
}
add_filter( 'query_vars', 'miyazaki_en_query_vars' );

/////////////////////////////////////////////////////
// Add WP REST API Endpoints
function miyazaki_en_rest_api_init() {
	register_rest_route( 'get_fruits', '/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'miyazaki_en_get_fruits',
		) );
}
add_action( 'rest_api_init', 'miyazaki_en_rest_api_init' );

function miyazaki_en_get_fruits( $params ) {

	$find = FALSE;
	$id = 0;
	$title = '';
	$content = '';

	$args = array(
		'p'					=> $params['id'],
		'posts_per_page'	=> 1,
		'post_type'			=> 'fruits',
		'post_status'		=> 'publish',
	);

	$the_query = new WP_Query($args);
	if ( $the_query->have_posts() ) :
		$find = TRUE;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$id = get_the_ID();
			$title = get_the_title( );
			$content = apply_filters('the_content', get_the_content() );
			break;
		endwhile;

		wp_reset_postdata();
	endif;

	if($find) {
		return new WP_REST_Response( array(
			'id'		=> $id,
			'title'		=> $title,
			'content'	=> $content,
		) );
	}
	else{
		$response = new WP_Error('error_code', 'Sorry, no posts matched your criteria.');
		return $response;
	}
}

/////////////////////////////////////////////////////
// show catchcopy at fruits tile
function miyazaki_en_get_catchcopy() {

	$catchcopy = get_field( 'catchcopy' );
	if( $catchcopy ){
		return '<p class="catchcopy">' .$catchcopy .'</p>';
	}

	return NULL;
}


//////////////////////////////////////////////////////
// show eyecarch on dashboard
function miyazaki_en_manage_posts_columns( $columns ) {
	$columns[ 'thumbnail' ] = __( 'Thumbnail' );
	return $columns;
}
add_filter( 'manage_posts_columns', 'miyazaki_en_manage_posts_columns' );
add_filter( 'manage_pages_columns', 'miyazaki_en_manage_posts_columns' );

function miyazaki_en_manage_posts_custom_column( $column_name, $post_id ) {
	if ( 'thumbnail' == $column_name ) {
		$thum = get_the_post_thumbnail( $post_id, 'small', array( 'style'=>'width:100px;height:auto;' ));
	} if ( isset( $thum ) && $thum ) {
		echo $thum;
	} else {
		echo __( 'None' );
	}
}
add_action( 'manage_posts_custom_column', 'miyazaki_en_manage_posts_custom_column', 10, 2 );
add_action( 'manage_pages_custom_column', 'miyazaki_en_manage_posts_custom_column', 10, 2 );

//////////////////////////////////////////////////////
// add body class
function miyazaki_en_body_class( $classes ) {
	if ( is_page() ) {
		$page = get_post( get_the_ID() );
		$classes[] = $page->post_name;
	}

	return $classes;
}
add_filter( 'body_class', 'miyazaki_en_body_class' );

//////////////////////////////////////////////////////
// login logo
function miyazaki_en_login_head() {

	$url = get_stylesheet_directory_uri() .'/images/login.png';
	echo '<style type="text/css">.login h1 a { background-image:url(' .$url .'); height: 84px; width: 320px; background-size: 100% 100%;}</style>';
}
add_action('login_head', 'miyazaki_en_login_head');

//////////////////////////////////////////////////////
// remove emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles', 10 );

//////////////////////////////////////////////////////
// set favicon
function miyazaki_en_favicon() {
//	echo '<link rel="shortcut icon" type="image/x-icon" href="' .get_stylesheet_directory_uri(). '/images/favicon.ico" />'. "\n";
}
add_action( 'wp_head', 'miyazaki_en_favicon' );