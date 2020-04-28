</php
/**
* Template Name: Контакти
*/
?>
<?php get_header();
$object_location = get_field_object('address', 'option');
$object_tel = get_field_object('phone', 'option');
$object_email = get_field_object('email', 'option');

if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div class="row contacts">
        <div class="col-left">
            <div class="content">
                <div class="title-spirit"><?php the_title(); ?></div>
                <h1 class="title"><?php the_title(); ?></h1>

                <?php if (!empty($object_location['value'])) { ?>
					<div class="address link">
						<a class="href-icon">
                            <div>
							    <span>
								    <img title="location" alt="location" class="mail" width="20" height="20" src="<?php echo get_template_directory_uri(); ?>/images/contacts/location.svg">
								    <img title="location" alt="location" class="mail hover-im" width="20" height="20" src="<?php echo get_template_directory_uri(); ?>/images/contacts/location-hover.svg">
                                </span>
                            </div>
                            <div class="placer ">
                                <?php echo $object_location['value']; ?>
                            </div>
						</a>
					</div>
                <?php } ?>

                <?php if (!empty($object_tel['value']['title'])) { ?>
					<div class="telnumber link">
						<a class="href-icon" href="<?php echo $object_tel['value']['url']; ?>">
						<div>
							<span>
							    <img title="Phone" alt="Phone" class="phone" width="20" height="20" src="<?php echo get_template_directory_uri(); ?>/images/phone-white.svg">
							    <img title="Phone" alt="Phone" class="phone hover-im" width="20" height="20" src="<?php echo get_template_directory_uri(); ?>/images/phone-hover.svg">
                            </span>
                        </div>
                            <div class="placer">
                                <?php echo $object_tel['value']['title']; ?>
                            </div>
						</a>
					</div>
				<?php } ?>
                
                <?php if (!empty($object_email['value'])) { ?>
					<div class="email link">
						<a class="href-icon" href="mailto:<?php echo $object_email['value']; ?>">
						<div>
							<span>
								<img title="Mail" alt="Mail" class="mail" width="20" height="14" src="<?php echo get_template_directory_uri(); ?>/images/mail-white.svg">
								<img title="Mail" alt="Mail" class="mail hover-im" width="20" height="14" src="<?php echo get_template_directory_uri(); ?>/images/mail-hover.svg">
                            </span>
                        </div>
                            <div class="placer">
                                <?php echo $object_email['value']; ?>
                            </div>
						</a>
					</div>
				<?php } ?>
                               
            </div>
        </div>
        <div class="col-right">
            <div id="map"></div>
        </div>
    </div>
<?php endwhile;
//AIzaSyBFH8ZQVDvhcnrh_lPHFrDpzZmIbLmaMqY
$googleapi = get_field('googleapi', 'option');
wp_enqueue_script('map', get_stylesheet_directory_uri() .'/js/map.js');
wp_enqueue_script('map.api', 'https://maps.googleapis.com/maps/api/js?key='.$googleapi.'&callback=initMap');
get_footer(); ?>