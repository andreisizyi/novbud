<?php
/**
 * Шаблон шапки (header.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php /* RSS и всякое */ ?>
	<link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="Comments RSS" href="<?php bloginfo('comments_rss2_url'); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
	<header class="parallax-background">
		<div class="header-content parallax-shadow">
			<div class="header-block-1">
				<?php if (!is_front_page()): ?><a href="/"><?php endif; ?>
					<img title="Novbud" alt="Novbud" class="logo" width="638" height="80" src="<?php echo get_template_directory_uri(); ?>/images/logo.svg">
				<?php if (!is_front_page()): ?></a><?php endif; ?>
				<div class="description">
				<?php echo get_bloginfo('description'); ?>
				</div>
			</div>
			<div class="header-block-2">
				<div class="left">
					<div class="languages">	
						<a class="active" href="">Русский</a>  <span>|</span>  <a href="">Английский</a>
					</div>
					<nav class="menu-header setline">
						<?php if (has_nav_menu('header-menu')) {
							wp_nav_menu( array( 'theme_location' => 'header-menu' ));
						} ?>
					</nav>
				</div>
				<div class="right">
					<div class="tel">
						<a href="tel:+380674095645">(067) 409-56-45</a>
					</div>
					<div class="bottom">
						<div class="bino setline">
							<a href="">ЗАКАЗАТЬ ЗВОНОК</a>
						</div>
						<div class="social">
							<a target="_blank" href="https://www.facebook.com/novbud.ua"><img title="Facebook" alt="Facebook" src="<?php echo get_template_directory_uri() ?>/images/facebook.svg"></a>
							<a target="_blank" href="https://www.instagram.com/novbud_ua"><img title="Instagram" alt="Instagram" src="<?php echo get_template_directory_uri() ?>/images/instagram.svg"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<main>