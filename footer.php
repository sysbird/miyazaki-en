	<footer id="footer">
		<section id="widget-area">
			<div class="container">
				<div class="left">
					<?php dynamic_sidebar( 'widget-area-footer' ); ?>
				</div>
				<div class="right">
					<?php if (!is_user_logged_in()): ?>		
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5&appId=6028400162";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-page" data-href="https://www.facebook.com/宮崎園-428742304135708" data-tabs="timeline" data-width="460" data-height="500" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/宮崎園-428742304135708"><a href="https://www.facebook.com/宮崎園-428742304135708">宮崎園</a></blockquote></div></div>
					<?php else: ?>
						<div class="widget">
						<h3><a href="<?php echo get_post_type_archive_link( 'manual' ); ?>">更新マニュアル</a></h3>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

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