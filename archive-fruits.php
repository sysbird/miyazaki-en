<?php get_header(); ?>

<div id="content">
	<div class="container">

		<article class="hentry">
			<header class="content-header">
				<h1 class="content-title">
				<?php echo esc_html( get_post_type_object( 'fruits')->label ); ?>
				</h1>
			</header>

			<?php if ( have_posts() ) : ?>
				<div class="tile">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'fruits' ); ?>
					<?php endwhile; ?>

				</div>
			<?php endif; ?>
		</article>
	</div>
</div>

<?php get_footer(); ?>
