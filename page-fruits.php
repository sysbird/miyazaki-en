<?php get_header();
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<div id="content">
	<div class="container">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if(1 == $paged ): ?>
			<?php get_template_part( 'content', 'singular' ); ?>
			<?php if ( wp_is_mobile() ): ?>
				<?php
					$page = get_page_by_path( 'calendar' );
				?>
				<p><a href="<?php echo get_the_permalink( $page->ID); ?>">&raquo; <?php echo $page->post_title; ?></a></p>
			<?php else: ?>
				<?php echo do_shortcode( '[miyazaki_en_fruits_calendar]' ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php $posts_per_page = get_option( 'posts_per_page' );
			$offset = $posts_per_page * ( $paged -1 );

			$args = array(
				'posts_per_page'	=> $posts_per_page,
				'offset'			=> $offset,
				'post_type'		=> 'fruits',
				'post_status'		=> 'publish',
			);

			$the_query = new WP_Query($args);
			if ( $the_query->have_posts() ) :
		?>
				<div class="tile">

					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<?php get_template_part( 'content', 'fruits' ); ?>
					<?php endwhile; ?>
				</div>

		<?php endif;
			wp_reset_postdata();
		?>

	</article>

<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>
