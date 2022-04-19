<?php
/**
 * Template name: Algo Homepage
 */
get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php do_action('algo_homepage'); ?>
		</main>
	</div>
<?php
do_action('storefront_sidebar');
get_footer();
