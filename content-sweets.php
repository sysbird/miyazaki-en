<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( has_post_thumbnail() ): ?>
		<div class="entry-eyecatch"><?php the_post_thumbnail(  get_the_ID(), 'large' ); ?></div>
	<?php endif; ?>
	<header class="entry-header"><h3 class="entry-title"><?php the_title(); ?></h3><?php echo miyazaki_en_get_sweets_price(); ?><?php the_content(); ?></header>
</div>
