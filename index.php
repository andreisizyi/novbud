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

<?php
wp_enqueue_script('paralax', get_stylesheet_directory_uri() .'/js/paralax.js');
wp_enqueue_script('owl.carousel', get_stylesheet_directory_uri() .'/js/owl.carousel.min.js');
wp_enqueue_style( 'owl.carousel', get_template_directory_uri().'/css/owl.carousel.min.css' );
wp_enqueue_script('owl.init', get_stylesheet_directory_uri() .'/js/owl.init.js', array('jquery') );
wp_enqueue_script('fancybox', get_stylesheet_directory_uri() .'/js/jquery.fancybox.min.js');
wp_enqueue_style( 'fancybox', get_template_directory_uri().'/css/jquery.fancybox.min.css' );
get_footer(); ?>
<script>
	jQuery('').fancybox({
		
	});
</script>
<?php get_footer(); ?>

