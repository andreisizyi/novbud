<?php
/**
 * Функции шаблона (function.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
add_theme_support('title-tag');

register_nav_menus( array(
	'header-menu'  => 'Меню у хедері сайту'
));
add_theme_support('post-thumbnails');
set_post_thumbnail_size(300, 300);
add_image_size('awards', 351, 510, true);

function true_remove_default_image_sizes( $sizes ) {
	unset( $sizes['thumbnail']);
	unset( $sizes['medium']);
	unset( $sizes['large']);
	return $sizes;
}
 
add_filter('intermediate_image_sizes_advanced', 'true_remove_default_image_sizes');

if (!function_exists('pagination')) {
	function pagination() {
		global $wp_query;
		$big = 999999999;
		$links = paginate_links(array(
			'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))),
			'format' => '?paged=%#%',
			'current' => max(1, get_query_var('paged')),
			'type' => 'array',
			'prev_text'    => 'Назад',
	    	'next_text'    => 'Вперед',
			'total' => $wp_query->max_num_pages,
			'show_all'     => false,
			'end_size'     => 15,
			'mid_size'     => 15,
			'add_args'     => false,
			'add_fragment' => '',
			'before_page_number' => '',
			'after_page_number' => ''
		));
	 	if( is_array( $links ) ) {
		    echo '<ul class="pagination">';
		    foreach ( $links as $link ) {
		    	if ( strpos( $link, 'current' ) !== false ) echo "<li class='active'>$link</li>";
		        else echo "<li>$link</li>"; 
		    }
		   	echo '</ul>';
		 }
	}
}

add_action('wp_head', 'add_scripts');
if (!function_exists('add_scripts')) {
	function add_scripts() {
	    if(is_admin()) return false;
	    wp_deregister_script('jquery');
	    wp_enqueue_script('jquery','//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js','','',true);
		wp_enqueue_script('jquery-timing', get_template_directory_uri().'/js/jquery-timing.min.js','','',true);
		wp_enqueue_script('polyfill', get_template_directory_uri().'/js/polyfill.foreach.js','','',true);
		wp_enqueue_script('menu', get_template_directory_uri().'/js/menu.js','','',true);
	}
}

add_action('wp_print_styles', 'add_styles');
if (!function_exists('add_styles')) {
	function add_styles() {
	    if(is_admin()) return false;
		wp_enqueue_style( 'bootstrap-reboot', get_template_directory_uri().'/css/bootstrap-reboot.min.css' );
		wp_enqueue_style( 'main', get_template_directory_uri().'/css/select2.min.css' );
		wp_enqueue_style( 'style', get_template_directory_uri().'/scss/style.css' );
		wp_enqueue_style( 'main', get_template_directory_uri().'/style.css' );
	}
}

if (!class_exists('bootstrap_menu')) {
	class bootstrap_menu extends Walker_Nav_Menu {
		private $open_submenu_on_hover;

		function __construct($open_submenu_on_hover = true) {
	        $this->open_submenu_on_hover = $open_submenu_on_hover;
	    }

		function start_lvl(&$output, $depth = 0, $args = array()) {
			$output .= "\n<ul class=\"dropdown-menu\">\n";
		}
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			$item_html = '';
			parent::start_el($item_html, $item, $depth, $args);
			if ( $item->is_dropdown && $depth === 0 ) {
			   if (!$this->open_submenu_on_hover) $item_html = str_replace('<a', '<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"', $item_html);
			   $item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html);
			}
			$output .= $item_html;
		}
		function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
			if ( $element->current ) $element->classes[] = 'active';
			$element->is_dropdown = !empty( $children_elements[$element->ID] );
			if ( $element->is_dropdown ) {
			    if ( $depth === 0 ) {
			        $element->classes[] = 'dropdown';
			        if ($this->open_submenu_on_hover) $element->classes[] = 'show-on-hover';
			    } elseif ( $depth === 1 ) {
			        $element->classes[] = 'dropdown-submenu';
			    }
			}
			parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}
	}
}

if (!function_exists('content_class_by_sidebar')) {
	function content_class_by_sidebar() {
		if (is_active_sidebar( 'sidebar' )) { 
			echo 'col-sm-9';
		} else { 
			echo 'col-sm-12';
		}
	}
}
/*Developed by Andrii Sizyi*/ 
function template_path(){
	 return get_template_directory_uri();
}
add_shortcode('template_path', 'template_path');

function h2($atts, $content = null) {
  return '<h2>'.$content.'</h2>';
}
add_shortcode('h2', 'h2');

function div($atts, $content = null) {
  return '<div class="text56 m-auto"><p>'.$content.'</p></div>';
}
add_shortcode('div', 'div');

/* Breadcrumbs */
function dimox_breadcrumbs() {

	/* === ОПЦИИ === */
	$text['home']     = 'Главная'; // текст ссылки "Главная"
	$text['category'] = '%s'; // текст для страницы рубрики
	$text['search']   = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
	$text['tag']      = 'Записи с тегом "%s"'; // текст для страницы тега
	$text['author']   = 'Статьи автора %s'; // текст для страницы автора
	$text['404']      = 'Ошибка 404'; // текст для страницы 404
	$text['page']     = 'Страница %s'; // текст 'Страница N'
	$text['cpage']    = 'Страница комментариев %s'; // текст 'Страница комментариев N'

	$wrap_before    = '<div class="breadcrumbs container text-center w-100" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
	$wrap_after     = '</div><!-- .breadcrumbs -->'; // закрывающий тег обертки
	$sep            = '<span class="breadcrumbs__separator"> / </span>'; // разделитель между "крошками"
	$before         = '<span class="breadcrumbs__current">'; // тег перед текущей "крошкой"
	$after          = '</span>'; // тег после текущей "крошки"

	$show_on_home   = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
	$show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
	$show_current   = 1; // 1 - показывать название текущей страницы, 0 - не показывать
	$show_last_sep  = 1; // 1 - показывать последний разделитель, когда название текущей страницы не отображается, 0 - не показывать
	/* === КОНЕЦ ОПЦИЙ === */

	global $post;
	$home_url       = home_url('/');
	$link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link          .= '<meta itemprop="position" content="%3$s" />';
	$link          .= '</span>';
	$parent_id      = ( $post ) ? $post->post_parent : '';
	$home_link      = sprintf( $link, $home_url, $text['home'], 1 );

	if ( is_home() || is_front_page() ) {

		if ( $show_on_home ) echo $wrap_before . $home_link . $wrap_after;

	} else {

		$position = 0;

		echo $wrap_before;

		if ( $show_home_link ) {
			$position += 1;
			echo $home_link;
		}

		if ( is_category() ) {
			$parents = get_ancestors( get_query_var('cat'), 'category' );
			foreach ( array_reverse( $parents ) as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$cat = get_query_var('cat');
				echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_search() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $show_home_link ) echo $sep;
				echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) echo $sep;
					echo $before . sprintf( $text['search'], get_search_query() ) . $after;
				} elseif ( $show_last_sep ) echo $sep;
			}

		} elseif ( is_year() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_time('Y') . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_month() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_day() ) {
			if ( $show_home_link ) echo $sep;
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
			$position += 1;
			echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
			if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_single() && ! is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$position += 1;
				$post_type = get_post_type_object( get_post_type() );
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
				if ( $show_current ) echo $sep . $before . get_the_title() . $after;
				elseif ( $show_last_sep ) echo $sep;
			} else {
				$cat = get_the_category(); $catID = $cat[0]->cat_ID;
				$parents = get_ancestors( $catID, 'category' );
				$parents = array_reverse( $parents );
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'cpage' ) ) {
					$position += 1;
					echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
					echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
				} else {
					if ( $show_current ) echo $sep . $before . get_the_title() . $after;
					elseif ( $show_last_sep ) echo $sep;
				}
			}
		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . $post_type->label . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_attachment() ) {
			$parent = get_post( $parent_id );
			$cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
			$parents = get_ancestors( $catID, 'category' );
			$parents = array_reverse( $parents );
			$parents[] = $catID;
			foreach ( $parents as $cat ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			$position += 1;
			echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_page() && ! $parent_id ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . get_the_title() . $after;
			elseif ( $show_home_link && $show_last_sep ) echo $sep;

		} elseif ( is_page() && $parent_id ) {
			$parents = get_post_ancestors( get_the_ID() );
			foreach ( array_reverse( $parents ) as $pageID ) {
				$position += 1;
				if ( $position > 1 ) echo $sep;
				echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
			}
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( is_tag() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$tagID = get_query_var( 'tag_id' );
				echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_author() ) {
			$author = get_userdata( get_query_var( 'author' ) );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			}

		} elseif ( is_404() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . $text['404'] . $after;
			elseif ( $show_last_sep ) echo $sep;

		} elseif ( has_post_format() && ! is_singular() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			echo get_post_format_string( get_post_format() );
		}

		echo $wrap_after;

	}
}
// Определям устройство ПК/моб
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
/*Pagination*/
function wp_corenavi() {
  global $wp_query;
  $total = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
  $a['total'] = $total;
  $a['mid_size'] = 2; // сколько ссылок показывать слева и справа от текущей
  $a['end_size'] = 1; // сколько ссылок показывать в начале и в конце
  $a['prev_text'] = 'Предыдущая'; // текст ссылки "Предыдущая страница"
  $a['next_text'] = 'Следующая'; // текст ссылки "Следующая страница"

  if ( $total > 1 ) echo '<nav class="pagination">';
  echo paginate_links( $a );
  if ( $total > 1 ) echo '</nav>';
}
/*The excerpt*/
function get_excerpt($limit, $source = null){
    $excerpt = $source == "content" ? get_the_content() : get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt.'...';
    return $excerpt;
}
// AJAX загрузка постов в портфолио
function load_posts () {
	//Получаем данные о текущей выборке
	$args = unserialize( stripslashes( $_POST['query'] ) );
	$args['category_name'] = 'ourprojects';
	$args['offset'] = $_POST['tpl'] - $_POST['elements'];
	$args['posts_per_page'] = 1;
	$current_posts =  explode(',', $_POST['other-posts']);
	$dir=$_POST['direction'];
	$left= 'left';
	if($dir == $left):
		//Убираем последний елемент массива
		array_pop($current_posts);
	else:
		//Убираем первый елемент массива
		array_shift($current_posts);
	endif;
	//Получим айди предыдущего/следующего поста
	query_posts( $args );
	if(have_posts()):
		while(have_posts()):the_post();
			if($dir == $left):
				//Добавим айди в массив в конец
				array_unshift($current_posts, get_the_ID());
			else:
				//Добавим айди в массив в начало
				array_push($current_posts, get_the_ID());
			endif;
		endwhile;
	else:
		print 'Больше записей нет';
		die();
	endif;
	//Выводим общий массив по фильтру
	$args2['post__in'] = $current_posts;
	//Преабразовываем текущий массив в встроку
	$current_posts = implode(",", $current_posts);
	//Выставляем атрибуты кнопка --текущий пост и текущая страница
	echo '<script type="text/javascript">
	jQuery(".btn-next-clients").attr("data-other-posts",'.json_encode($current_posts).');
	jQuery(".btn-back-clients").attr("data-other-posts",'.json_encode($current_posts).');';
	if ($dir == $left) {
		echo 'jQuery(".btn-next-clients").attr("data-page-number",'.json_encode($_POST['page-number']-1).');
		jQuery(".btn-back-clients").attr("data-page-number",'.json_encode($_POST['page-number']-1).');';
	} else {
		echo 'jQuery(".btn-next-clients").attr("data-page-number",'.json_encode($_POST['page-number']+1).');
		jQuery(".btn-back-clients").attr("data-page-number",'.json_encode($_POST['page-number']+1).');';
	}
	echo '</script>';
	query_posts( $args2 );
	if(have_posts()):
		while(have_posts()):the_post();
			echo '<div class="honeycomb"><a class="honeycomb-in" data-thumbnail="'.wp_get_attachment_image_url(get_post_thumbnail_id(), 'cover').'" href="'.get_permalink().'">';
				the_title();
			echo '</a></div>';
		endwhile;
		die();
	endif;
}
add_action('wp_ajax_loadmore', 'load_posts');
add_action('wp_ajax_nopriv_loadmore', 'load_posts');
//Options page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Налаштування сайту',
		'menu_title'	=> 'Налаштування сайту',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}
$cur_user_id = get_current_user_id();
if ($cur_user_id == 2) {
	function remove_menus(){
	  remove_menu_page( 'index.php' );                  //Консоль
	 // remove_menu_page( 'edit.php' );                   //Записи
	 // remove_menu_page( 'upload.php' );                 //Медиафайлы
	 // remove_menu_page( 'edit.php?post_type=page' );    //Страницы
	  remove_menu_page( 'edit-comments.php' );          //Комментарии
	//remove_menu_page( 'themes.php' );                 //Внешний вид
	  remove_menu_page( 'plugins.php' );                //Плагины
	 remove_menu_page( 'users.php' );                  //Пользователи 
	  remove_menu_page( 'tools.php' );                  //Инструменты
	  remove_menu_page( 'options-general.php' );        //Настройки
	  remove_menu_page( 'smush' );
	 // remove_menu_page('wpcf7');   // Contact form 7
	  remove_menu_page('edit.php?post_type=adlpostslider');   // Slider
	  remove_menu_page('edit.php?post_type=acf-field-group');   // Группы полей
	  // remove_menu_page('footer_options'); //Footer options
	 /* remove_menu_page('profile.php'); */  // Профиль
	}
	add_action( 'admin_menu', 'remove_menus' );
	function remove_jetpack_menu() {
		remove_menu_page( 'edit.php?post_type=popup' );
		//remove_menu_page( 'leaflet-map' );
		//remove_menu_page( 'all-in-one-seo-pack/aioseop_class.php');
	}
	/** Admin bar **/
	function wph_new_toolbar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_menu('popup-maker');
		$wp_admin_bar->remove_menu('pwa_menu_bar');	
	}
	add_action('wp_before_admin_bar_render', 'wph_new_toolbar');
}
?>