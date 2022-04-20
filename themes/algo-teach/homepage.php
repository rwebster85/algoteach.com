<?php
/**
 * Template name: Algo Homepage
 */
// Code adapted from Automattic, Inc, 2022
get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php do_action('algo_homepage'); ?>
		</main>
	</div>
<?php
do_action('storefront_sidebar');
get_footer();
// end of adapted code
