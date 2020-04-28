</php
/**
* Template Name: Про нас
*/
?>
<?php get_header();
if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div class="row aboutus first">
        <div class="col-left">
            <?php the_post_thumbnail('wedesign'); ?>
        </div>
        <div class="col-right">
            <div class="title-spirit"><?php the_title(); ?></div>
            <h1 class="title"><?php the_title(); ?></h1>
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
    <?php if( have_rows('aboutus', 'option') ): ?>
        <div class="row aboutus">
            <div class="col-left">
            </div>
            <div class="col-right">
                <div class="row">
                    <?php
                        while ( have_rows('aboutus', 'option') ) : the_row();
                            echo
                            '<div class="col-1-3">
                            <div class="infographics">
                                <div class="amount">'.
                                    get_sub_field('amount', 'option').
                                '</div>
                                <div class="name">'.
                                    get_sub_field('name', 'option').
                                '</div>
                            </div></div>';
                        endwhile;
                    ?>
                </div>
                <div class="content">
                    <?php echo get_field('block_2') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if( have_rows('ourteam') ): ?>
        <div class="row team">
            <div class="col-left">
            </div>
            <div class="col-right">
                <div class="content">
                    <?php 
                        while ( have_rows('ourteam') ) : the_row();
                            echo 
                            '<div class="title-spirit">'.
                                get_sub_field('name').
                            '</div>'.
                            '<h2 class="title">'.
                                get_sub_field('name').
                            '</h2>
                            <iframe width="950" height="534" src="
                            '.get_sub_field('link').
                            '?showinfo=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        endwhile;
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if( have_rows('clients') ): ?>
        <div class="row clients">
            <div class="col-left">
            </div>
            <div class="col-right">
                <?php $object_clients = get_field_object('clients'); ?>
                <div class="title-spirit"><?php echo $object_clients['label']; ?></div>
                <h2 class="title"><?php echo $object_clients['label']; ?></h2>
                <div class="owl-logo-wrapper small">
                    <div class="owl-carousel owl-logo owl-theme">
                            <?php 
                                //Считаем общее количество элементов
                                $last=1;
                                while ( have_rows('clients') ) : the_row();
                                    $last++;
                                endwhile;
                                //Ставим условие для объединения элементов
                                $i=1;
                                echo '<div class="item">';
                                while ( have_rows('clients') ) : the_row();  
                                    echo wp_get_attachment_image(get_sub_field('logo'), 'logo', false, array('class' => 'client-logo'));
                                    if (($last - $i) == 1) :
                                        echo '</div>';
                                    elseif (($i % 4) == 0) :
                                        echo '</div><div class="item">';
                                    endif;
                                    $i++;
                                endwhile;
                            ?>
                    </div>
                </div>
                <div class="owl-logo-wrapper large">
                    <div class="owl-carousel owl-logo owl-theme">
                            <?php 
                                while ( have_rows('clients') ) : the_row();  
                                echo '<div class="item">'.
                                wp_get_attachment_image(get_sub_field('logo'), 'logo', false, array('class' => 'client-logo')).
                                '</div>';
                                endwhile;
                            ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php endwhile;
wp_enqueue_script('owl.carousel', get_stylesheet_directory_uri() .'/js/owl.carousel.min.js');
wp_enqueue_style( 'owl.carousel', get_template_directory_uri().'/css/owl.carousel.min.css' );
wp_enqueue_script('owl.init', get_stylesheet_directory_uri() .'/js/owl.init.js', array('jquery') );
get_footer(); ?>