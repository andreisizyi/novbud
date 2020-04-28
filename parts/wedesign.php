</php
/**
* Template Name: Ми проектуємо
*/
?>
<?php get_header();
if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div class="row wedesign first">
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
    <div class="row wedesign">
        <div class="col-left">
        </div>
        <div class="col-right">
            <div class="title-spirit">Залишити заявку</div>
            <h2 class="title">Залишити заявку</h2>
            <form method="post" class="form" id="ajax_form" action="">
               <div class="form-content">
                    <div class="form-col">
                        <select class="js-form" name="typebuilding">
                            <option name="type" value="" disabled selected>Тип споруди, який вас цікавить</option>
                            <?php
                                if( have_rows('typesbuilding', 'option') ):
                                    while ( have_rows('typesbuilding', 'option') ) : the_row();
                                        echo '<option value="'. get_sub_field('type', 'option').'">'.
                                        get_sub_field('type', 'option')
                                        .'</option>';
                                    endwhile;
                                else :
                                endif;
                            ?>
                        </select>
                    </div>
                    <div class="form-col number">
                        <input type="tel" name="phonenumber" placeholder="Ваш номер телефону" />
                    </div>
                </div>
                <div id="button-container">
                    <input type="submit" id="submit" value="Відправити" />
                </div>
            </form>
        </div>
    </div>
<?php
endwhile;
wp_enqueue_script('select2', get_stylesheet_directory_uri() .'/js/select2.min.js', array('jquery') );
wp_enqueue_script('mask', get_stylesheet_directory_uri() .'/js/jquery.mask.js', array('jquery') );
wp_enqueue_script('form', get_stylesheet_directory_uri() .'/js/form.js', array('jquery') );
wp_enqueue_style( 'form', get_template_directory_uri().'/scss/form.css' );
get_footer(); ?>