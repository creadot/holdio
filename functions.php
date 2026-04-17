<?php

/****** BETTER IMAGE SIZES WRAPPER **************************************************************************************************/

require_once(__DIR__."/inc/Img.php");

/****** INDEX NO FOLLOW INDICATOR ***************************************************************************************************/

function blog_public_warning() {
	if(get_option("blog_public") == 0) {
		echo '<style>
			#menu-settings,
			#menu-settings ul li:nth-child(4) {
				background: #c00 !important;
			}
		</style>';
	}
	else {
		echo '<style>
			#menu-settings,
			#menu-settings ul li:nth-child(4) {
				background: rgba(0, 255, 96, 0.2) !important;
			}
		</style>';

		if (strpos($_SERVER['SERVER_NAME'], ".test") !== false || strpos($_SERVER['SERVER_NAME'], ".crdt.xyz") !== false) {
			add_action( 'admin_notices', 'blog_public_warning_notice' );
		}
	}
}
add_action('admin_head', 'blog_public_warning');

function blog_public_warning_notice() {
	$class = 'notice notice-error';
	printf( '<div class="%1$s"><p><strong>Pozor, máš povolenou indexaci, i když jsi na testu &ndash; <a href="/wp-admin/options-reading.php">jít do nastavení</a></strong></p></div>', esc_attr( $class ));
}


/****** REMOVE P TAG FROM CF7 *******************************************************************************************************/

add_filter('wpcf7_autop_or_not', '__return_false');

/****** FORM SEND EVENTS ************************************************************************************************************/

function footer_scripts() {
    ?>
    <script>
        document.addEventListener('wpcf7mailsent', function(event) {
            var form = "form";
            dataLayer.push({
                "event": "contact_form_sent",
                "form": form,
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'footer_scripts');


/****** DISABLE GUTENBERG EDITOR **************************************************************************************************/

// add_action('admin_init', 'remove_gutenberg_editor_for_templates');
// function remove_gutenberg_editor_for_templates() {
//   if (isset($_GET['post'])) {
//     $post_id = $_GET['post'];
//     $post_type = get_post_type($post_id);

//     // Pro stránky, které mají šablonu bez editoru
//     if ($post_type == 'page') {
//       $template_file = get_post_meta($post_id, '_wp_page_template', true);

//       if ($template_file == 'archive-case_study_cpt.php' ||
//           $template_file == 'page_contact.php' /*||
//           $template_file == 'page_about.php'*/) {
//         remove_post_type_support('page', 'editor');
//       }
//     }

//     // Skryje editor na úvodní stránce a blogové stránce
//     if (get_option('page_on_front') == $post_id || get_option('page_for_posts') == $post_id) {
//       remove_post_type_support('page', 'editor');
//     }
//     if ($post_type == 'post') {
//       remove_post_type_support('post', 'editor');
//     }
//   }
// }

/****** HIDE ADMIN MENU ITEMS *******************************************************************************************************/

function wpdocs_remove_menus(){
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'wpdocs_remove_menus' );

add_action('init', 'remove_comment_support', 100);

function remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}

function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );


/****** LOGIN PAGE LOGO *************************************************************************************************************/

function custom_wp_login_logo() { ?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri() . '/img/logo-text.svg' ?>);
			width: 300px;
			height: 100px;
			background-size: 300px 100px;
			background-repeat: no-repeat;
			padding-bottom: 10px;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_wp_login_logo' );

/****** LOGIN PAGE LANGUAGE SWITCHER DISABLER ******************************************************************************************/

add_filter( 'login_display_language_dropdown', '__return_false' );

/****** LOGIN PAGE FAVICON *************************************************************************************************************/
function add_site_favicon() {
	echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/img/favicons/favicon.ico" />';
}
add_action('login_head', 'add_site_favicon');
add_action('admin_head', 'add_site_favicon');

/****** BASIC THEME SETUP *************************************************************************************************************/

function theme_setup() {
	/*  Thumnails + define sizes */
	add_theme_support('post-thumbnails');

	/* Register menu navigation */
	register_nav_menus(array(
		'primary'   => 'Hlavní menu'
	));
}
add_action( 'after_setup_theme', 'theme_setup' );


/****** ACF JSON SAVE POINT *************************************************************************************************************/

function acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'acf_json_save_point' );


/****** SECURITY *************************************************************************************************************/

function disable_extra() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action('rest_api_init', 'wp_oembed_register_route');
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	// Remove unnecessary tags
	remove_action( 'wp_head', 'wp_generator' ) ;
	remove_action( 'wp_head', 'wlwmanifest_link' ) ;
	remove_action( 'wp_head', 'rsd_link' ) ;
	remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
	remove_action( 'wp_head', 'rest_output_link_wp_head');
	remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
}
add_action('init', 'disable_extra');

/****** ODSTRAŇUJE WORDPRESS VERZI ******************************************************************************************************/

remove_action('wp_head', 'wp_generator');

/******  ŠÉFREDAKTOR MŮŽE MĚNIT MENU *******************************************************************************************/

function add_editor_caps(){
    global $pagenow;
    $role = get_role('editor');

    if ('themes.php' == $pagenow && isset($_GET['activated'])) {
        $role->add_cap('edit_theme_options');
    }
}
add_action( 'load-themes.php', 'add_editor_caps' );


/******  REMOVE P TAG FROM IMAGES *******************************************************************************************/

function filter_ptags_on_images($content) {
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
add_filter('acf_the_content', 'filter_ptags_on_images', 9999);
add_filter('the_content', 'filter_ptags_on_images', 9999);


/******  HIDE TAGS FROM POST *******************************************************************************************/

// function disable_post_tags() {
//     // Získejte ID taxonomie 'post_tag'
//     global $wp_taxonomies;
    
//     if (isset($wp_taxonomies['post_tag'])) {
//         // Skrýt taxonomii tags z administrace
//         $wp_taxonomies['post_tag']->show_ui = false; // Skrýt UI
//         $wp_taxonomies['post_tag']->show_in_menu = false; // Skrýt v menu
//     }
// }
// add_action('init', 'disable_post_tags');


/******  ACTIVE MENU ITEMS *******************************************************************************************/

// function add_active_class_to_custom_post_type($classes, $item) {
//     if (is_post_type_archive('case_study_cpt') && $item->url == get_post_type_archive_link('case_study_cpt') ) {
//         $classes[] = 'current-menu-item';
//     }
//     if (is_singular('case_study_cpt')) {
//         $archive_reference_link = get_post_type_archive_link('case_study_cpt');
        
//         if ($item->url == $archive_reference_link) {
//             $classes[] = 'current-menu-item';
//         }

//         if ($item->object_id == get_queried_object_id()) {
//             $classes[] = 'current-menu-item';
//         }
//     }
//     if (is_singular('post')) {
//         $archive_aplikace_link = get_post_type_archive_link('post');
        
//         if ($item->url == $archive_aplikace_link) {
//             $classes[] = 'current-menu-item';
//         }

//         if ($item->object_id == get_queried_object_id()) {
//             $classes[] = 'current-menu-item';
//         }
//     }
//     return $classes;
// }
// add_filter('nav_menu_css_class', 'add_active_class_to_custom_post_type', 10, 2);

function remove_current_page_classes($items) {
    foreach ($items as $key => $item) {
        // Pokud je aktuální stránka front-page, odstraní třídy
        if (is_front_page()) {
            $items[$key]->classes = array_diff($item->classes, ['current-menu-item', 'current_page_item']);
        } elseif (in_array('current_page_parent', $item->classes) && (is_singular('service_cpt') || is_singular('company_cpt'))) {
            unset($item->classes[array_search('current_page_parent', $item->classes)]);
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'remove_current_page_classes');


/******  ACF OPTIONS PAGE *******************************************************************************************/

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

    if( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => 'Web - nastavení',
            'menu_title'    => 'Web',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
}

/******  CUSTOM POST TYPES *******************************************************************************************/

function register_cpts() {
    register_post_type( "service_cpt", [
        "label" => "Služby",
        "labels" => [
            "name" => "Služby",
            "singular_name" => "Služba",
            "add_new" => "Nová služba",
        ],
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => [
            "slug" => "sluzby",
            "with_front" => false,
        ],
        "query_var" => true,
        "menu_icon" => "dashicons-block-default",
        "supports" => [
            "title",
            "editor",
            "thumbnail",
            //"revisions",
            "author"
        ],
    ]);

    register_post_type( "company_cpt", [
        "label" => "Firmy",
        "labels" => [
            "name" => "Firmy",
            "singular_name" => "Firma",
            "add_new" => "Přidat firmu",
        ],
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => [
            "slug" => "firma",
            "with_front" => false,
        ],
        "query_var" => true,
        "menu_icon" => "dashicons-block-default",
        "supports" => [
            "title",
            "editor",
            "thumbnail",
            //"revisions",
            "author"
        ],
    ]);

}
add_action( 'init', 'register_cpts' );


/****** CUSTOM TAXONOMIES *******************************************************************************************/

function register_taxonomies() {

    register_taxonomy( 'service_cat', [ 'service_cpt' ], [
        'labels' => [
            'name' => 'Kategorie',
            'singular_name' => 'Kategorie',
            'menu_name' => 'Kategorie',
        ],
        'show_ui' => true,
        'show_admin_column' => true,
        "show_in_rest" => true,
        'query_var' => true,
        'rewrite' => [
            'slug' => 'service-category',
            'with_front' => true,
            'hierarchical' => true,
        ],
        'hierarchical' => true,
    ]);

}
add_action( 'init', 'register_taxonomies' );



/****** POST/TAX REDIRECT *******************************************************************************************/


function creadot_redirect_posts_or_tax_without_single() {
    if (is_tax('service_cat')) {
        //wp_safe_redirect(get_permalink(pll_get_post(2)), 301);
        wp_safe_redirect(get_permalink(pll_get_post(2)) . '#sluzby', 301);
        exit;
    }
    // elseif (is_singular('company_cpt')) {
    //     wp_safe_redirect(get_permalink(pll_get_post(2)), 301);
    //     exit;
    // }
    // elseif (is_tax('career-cities')) {
    //     wp_safe_redirect(get_permalink(pll_get_post(93)), 301);
    //     exit;
    // }
}
add_action( 'template_redirect', 'creadot_redirect_posts_or_tax_without_single' );




function get_reading_time($post_id) {
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $words_per_minute = 200;
    $reading_time = ceil($word_count / $words_per_minute);
    
    return $reading_time;
}


/******  SANITIZE *******************************************************************************************/

function sanitize_string($string) {
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    $string = trim($string, '-');
    return $string;
}

/******  TEXT PAGE BODY CLASS *******************************************************************************************/

// function text_page_body_class($classes) {
//     if (is_page() && !is_front_page() && !is_page_template('front-page.php')) {
//         $classes[] = 'simple-page';
//     }
//     return $classes;
// }
// add_filter('body_class', 'text_page_body_class');




/******  CO2 *************************************************************************************/

function creadotFormatCO2( $string ) {
    $string = str_replace( "CO2", "CO<sub>2</sub>", $string );
    // $string = str_replace( "N2O", "N<sub>2</sub>O", $string );
    // $string = str_replace( "CH4", "CH<sub>4</sub>", $string );
    return $string;
}

function creadotFormatCO2_acf( $value, $post_id, $field ) {
    return creadotFormatCO2( $value );
}
add_filter('acf/format_value/type=textarea', 'creadotFormatCO2_acf', 10, 3);
add_filter('acf/format_value/type=text', 'creadotFormatCO2_acf', 10, 3);
add_filter('acf/format_value/type=wysiwyg', 'creadotFormatCO2_acf', 10, 3);

function creadotFormatCO2_the_title( $title, $id = null ) {
    return creadotFormatCO2( $title );
}
add_filter( 'the_title', 'creadotFormatCO2_the_title', 10, 2 );