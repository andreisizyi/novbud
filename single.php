<?php get_header();
if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
	<div class="cover-project" style="background-image: url(<?php the_post_thumbnail_url('cover'); ?>)">
		<div class="title-block">
			<h1 class="title"><?php the_title(); ?></h1>
			<?php if(get_field("meteramount")): ?>
				<div class="meteramount">
					<?php the_field('meteramount'); ?> м<sup>2</sup>
				</div>
			<?php endif; ?>
		</div>
	</div>
	
	<section class="info">
		<?php if(get_field("introduction")): ?>
			<div class="row introduction">
				<div class="col-left">
					<?php echo wp_get_attachment_image(get_field('firstimg'), 'projectimg', false, array('class' => 'content-img')); ?>
				</div>
				<div class="col-right">
					<div class="content">
						<?php the_field('introduction'); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if(get_field("task")): ?>
			<div class="row task">
				<div class="col-left">
					<div class="content">
						<?php $object_task = get_field_object('task'); ?>
						<div class="title-spirit"><?php echo $object_task['label']; ?></div>
						<h2 class="title"><?php echo $object_task['label']; ?>:</h2>
						<?php the_field('task'); ?>
					</div>
				</div>
				<div class="col-right">
					<?php echo wp_get_attachment_image(get_field('secondimg'), 'projectimg', false, array('class' => 'content-img')); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if(get_field("task")): ?>
			<div class="row decision">
				<div class="col-center">
					<div class="content">
						<?php $object_decision = get_field_object('decision'); ?>
						<div class="title-spirit"><?php echo $object_decision['label']; ?></div>
						<h2 class="title"><?php echo $object_decision['label']; ?>:</h2>
						<div class="content">
							<?php the_field('decision'); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
	</section>

<?php endwhile;
get_footer(); ?>