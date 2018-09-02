<?php if (!is_user_logged_in()){
    header( "location: " . home_url() );
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" >
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div <?php birdfield_wrapper_class(); ?>>

	<header id="header">
		<div class="container">
			<div id="branding">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> id="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</<?php echo $heading_tag; ?>>
				<p id="site-description"><?php bloginfo( 'description' ); ?></p>
			</div>
		</div>
	</header>

<div id="content">
	<?php birdfield_content_header(); ?>

	<div class="container">

		<article class="hentry">
			<header class="content-header">
                <h1 class="content-title">更新マニュアル・目次</h1>
			</header>

			<?php if ( have_posts() ) : ?>
             <ul class="list">
					<?php while ( have_posts() ) : the_post(); ?>
                    <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdfield' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                        <header class="entry-header">
                            <h2 class="entry-title"><?php the_title(); ?></h2>
                        </header>
                        </a>
                    </li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
		</article>
	</div>

	<?php birdfield_content_footer(); ?>
</div>

	<footer id="footer">
		<div class="container">
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ) ; ?>">MIYAZAKI-EN</a>
				<?php printf( 'Copyright &copy; %s All Rights Reserved.', birdfield_get_copyright_year() ); ?>
			</div>
		</div>
		<p id="back-top"><a href="#top"><span><?php _e( 'Go Top', 'birdfield' ); ?></span></a></p>
	</footer>

</div><!-- wrapper -->

<?php wp_footer(); ?>

</body>
</html>