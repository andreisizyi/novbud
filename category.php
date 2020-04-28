<?php get_header(); ?> 
<section id="news" class="s-content">
	<div class="container">
	<?php
		$content = category_description();
		$content = wp_strip_all_tags($content);
		echo do_shortcode($content);
		
		echo '<div class="row vw-pad justify-content-center">';
			if (have_posts()) : while (have_posts()) : the_post();
					if (is_category('blog')):
						get_template_part('parts/loop-news');
					else:
						get_template_part('parts/loop-sales');
					endif;		
			endwhile;
			else: echo('<p>Материалов нет.</p>');
			endif;
		?>
			</div>
			<div class="w-100 d-flex justify-content-center">
				<?php if ( function_exists( 'wp_corenavi' ) ) wp_corenavi(); ?>
			</div>
	</div>
</section>
<?php
$post_id = get_post( 22 );
$content = $post_id->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
echo $content;
get_footer();
?>