<?php get_header();
if (is_front_page()){
	if ( have_posts() ) while ( have_posts() ) : the_post();
		$content = get_the_content();
		echo do_shortcode($content);
	endwhile;
} else {
	if ( have_posts() ) while ( have_posts() ) : the_post();
		the_content();
	endwhile;
}
get_footer(); ?>