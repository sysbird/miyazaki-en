<?php get_header(); ?>

<div id="content">
	<?php birdfield_content_header(); ?>

	<?php if( ! is_paged() ): ?>
		<?php birdfield_headerslider(); ?>
	<?php endif; ?>

	<?php if ( have_posts()) : ?>
		<section id="blog">
			<div class="container">
				<?php $category_id = get_cat_ID( 'お知らせ' ); ?>
				<h2><a href="<?php echo get_category_link( $category_id ); ?>">お知らせ</a></h2>

				<ul class="article">
				<?php while ( have_posts()) : the_post(); ?>
					<?php get_template_part( 'content', 'home' ); ?>
				<?php endwhile; ?>
				</ul>
				<div class="more"><a href="<?php echo get_category_link( $category_id ); ?>" >もっと見る</a></div>
			</div>
		</section>
	<?php endif; ?>

	<?php
		$args = array(
			'post_type' => 'page',
			'tag' => 'information',
			'post_status' => 'publish'
		);
		$the_query = new WP_Query($args);
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
	?>

	<section class="information <?php  echo get_post_field( 'post_name', get_the_ID() ); ?>">
		<div class="container">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<?php
				$more_url = get_the_permalink();
			?>

			<?php
				if( !( false === strpos( $post->post_name, 'fruit' ) ) ){
					echo do_shortcode('[miyazaki_en_fruits_list]');
				}
				else{
					the_content('');
				}
			?>

			<div class="more"><a href="<?php echo $more_url ; ?>">詳しく見る</a></div>

			<?php
				if( !( false === strpos( $post->post_name, 'access' ) ) ){
					echo do_shortcode('[miyazaki_en_map]');
				}
			?>

		</div>
	</section>

	<?php endwhile;
		wp_reset_postdata();
		endif;
	?>

	<section class="information">
	<?php  echo do_shortcode('[miyazaki_en_map]'); ?>
	</section>

	<?php birdfield_content_footer(); ?>
</div>

<?php get_footer(); ?>
