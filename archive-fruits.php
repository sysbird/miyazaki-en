<?php get_header(); ?>

<div id="content">
	<div class="container">

		<article class="hentry">
			<header class="content-header">
				<h1 class="content-title">
				<?php $title ='';
					$type = get_query_var('type') ;
					if( !empty( $type )){
						$title = igarashi_nouen_get_type_label( $type, FALSE );
						echo $title;
					}
					else {
						if( !empty( $season )){
							$season = get_query_var('season') ;
							$title = igarashi_nouen_get_season_label( $season, FALSE );
							echo $title .'の野菜';
						}
					}

					if( empty( $title )) {
						echo esc_html( get_post_type_object( 'vegetables')->label );
					}
				?>
				</h1>
			</header>

			<?php if ( have_posts() ) : ?>
				<div class="tile masonry">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'vegetables' ); ?>
					<?php endwhile; ?>

					<div class="pagenation more"><?php next_posts_link( 'もっとみる' ) ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/loading.gif" alt="" class="loading"></div>
				</div>
			<?php endif; ?>
		</article>
	</div>
</div>

<?php get_footer(); ?>
