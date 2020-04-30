<?php get_header(); ?>
<?php
//Выборка количество записей в зависимости от устройства
if(isMobileDevice()) :
	$postperpage = 10;
else :
	$postperpage = 10;
endif;
?>
<section class="awards">
	<?php 
	$images = get_field('awards', 'option');
	$size = 'awards';
	if( $images ): ?>
		<div class="owl-carousel owl-awards owl-theme">
			<?php foreach( $images as $image ): ?>
				<div class="item">
					<a class="popup-link" data-fancybox="gallery" href="<?php echo wp_get_attachment_image_url($image['ID']); ?>">
						<?php echo wp_get_attachment_image( $image['ID'], $size, false, array('class' => 'award-image')); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>		
</section>
<section class="projects">
	<?php
		$posts = get_posts( array(
			'post_type'  => 'page', 
			'orderby' => 'publish_date',
			'order' => 'ASC',
			'meta_query' => array( 
				array(
					'key'   => '_wp_page_template', 
					'value' => 'parts/page-residential.php'
				)
			)
		) );
		foreach( $posts as $post ){
			setup_postdata($post);
	?>
		<div class="left">
			<a href="<?php echo get_post_permalink(); ?>">
				<?php the_post_thumbnail('residential'); ?>
			</a>
		</div>
		<div class="right">
			<div class="block">
				<a href="<?php echo get_post_permalink(); ?>"><h2 class="title"><?php the_title(); ?></h2></a>
				<?php echo get_field('short'); ?>
				<a href="<?php echo get_post_permalink(); ?>"><button class="dark">Подробнее</button></a>
			</div>
		</div>	
	<?php	
		}
		wp_reset_postdata(); // сброс
	?>
</section>

<?php
wp_enqueue_script('paralax', get_stylesheet_directory_uri() .'/js/paralax.js');
wp_enqueue_script('owl.carousel', get_stylesheet_directory_uri() .'/js/owl.carousel.min.js');
wp_enqueue_style( 'owl.carousel', get_template_directory_uri().'/css/owl.carousel.min.css' );
wp_enqueue_script('owl.init', get_stylesheet_directory_uri() .'/js/owl.init.js', array('jquery') );
wp_enqueue_script('fancybox', get_stylesheet_directory_uri() .'/js/jquery.fancybox.min.js');
wp_enqueue_style( 'fancybox', get_template_directory_uri().'/css/jquery.fancybox.min.css' );
get_footer(); ?>
<?php get_footer(); ?>

