<?php
// remove vendor
remove_action( 'woocommerce_order_item_meta_start', 'dokan_attach_vendor_name', 10, 2 );
// remove field checkout
function remove_checkout_fields( $fields ) {
     unset($fields['billing']['billing_postcode']);
     return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'remove_checkout_fields' );
// hide tab addition infomation
function woo_additional_information_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_additional_information_remove_product_tabs', 98 );
add_action( 'wp_enqueue_scripts', 'molla_child_css', 1001 );
// Load CSS
function molla_child_css() {
	// molla child theme styles
	wp_deregister_style( 'styles-child' );
	wp_register_style( 'styles-child', esc_url( get_stylesheet_directory_uri() ) . '/style.css' );
	wp_enqueue_style( 'styles-child' );
}

// ------------------------CUSTOM FOR ROTICA-----------------------------

// change breadcrumb brands = Trường
add_filter( 'woocommerce_get_breadcrumb', 'custom_breadcrumb', 10, 2 );



function custom_breadcrumb( $crumbs, $object_class ){
    // Loop through all $crumb
    foreach( $crumbs as $key => $crumb ){
        $taxonomy = 'Brands';
        $term_array = term_exists( $crumb[0], $taxonomy );

        // if it is a product category term
        if ( $crumb[0] == $taxonomy ) {
					$crumbs[$key][0] = 'Trường';
        }
    }

    return $crumbs;
};


// get ALl provinces

add_action( 'wp_ajax_getAllProvinces', 'getAllProvinces' );
add_action( 'wp_ajax_getDistricts', 'getDistricts' );
add_action( 'wp_ajax_getWards', 'getWards' );

add_action( 'wp_ajax_nopriv_getAllProvinces', 'getAllProvinces' );
add_action( 'wp_ajax_nopriv_getDistricts', 'getDistricts' );
add_action( 'wp_ajax_nopriv_getWards', 'getWards' );

function my_enqueue_search() {
    wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery') );
    wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

// add_action( 'wp_enqueue_scripts', 'my_enqueue' );

function getAllProvinces(){
    global $wpdb;
    $result = array();
    $provinces = $wpdb->get_results("
    SELECT p.id, p.province as text
    FROM {$wpdb->prefix}provinces as p
    ");
    $response = new stdClass();
    

    if (is_array($provinces) && count($provinces) > 0)
        $result = $provinces;

    $arr = array('data' => $result);
    echo json_encode($arr);
    die();
}


function getDistricts(){
    global $wpdb;
    $result = array();
    if(!isset($_POST['provinceId'])){ 
        $districts = [];
    }else{
        if($_POST['s'])
        $query .= " AND d.district like '%".$_POST['s']."'%";

        $provinceId = $_POST['provinceId'];
        $districts = $wpdb->get_results("
        SELECT d.id, TRIM(CONCAT(d.prefix, ' ', d.name)) as text
        FROM {$wpdb->prefix}districts as d
        WHERE d.province_id = ".$provinceId."
        $query
        ");
    }


    if (is_array($districts) && count($districts) > 0)
        $result = $districts;

    $arr = array('data' => $result);
    echo json_encode($arr);
    die();
}

function getWards(){
    global $wpdb;
    $result = array();
    if(!isset($_POST['districtId'])){ 
        $wards = [];
    }else{
        if($_POST['s'])
        $query .= " AND w.ward like '%".$_POST['s']."'%";

        $districtId = $_POST['districtId'];
        $wards = $wpdb->get_results("
        SELECT w.id, TRIM(CONCAT(w.prefix, ' ', w.name)) as text
        FROM {$wpdb->prefix}wards as w
        WHERE w.district_id = ".$districtId."
        $query
        ");
    }


    if (is_array($wards) && count($wards) > 0)
        $result = $wards;

    $arr = array('data' => $result);
    echo json_encode($arr);
    die();
}

// hide update notifications
function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates'); //hide updates for WordPress itself
add_filter('pre_site_transient_update_plugins','remove_core_updates'); //hide updates for all plugins
add_filter('pre_site_transient_update_themes','remove_core_updates');

add_filter('hidden_meta_boxes', 'foo_hidden_meta_boxes', 10, 2);
function foo_hidden_meta_boxes($hidden, $screen) {
    $post_type= $screen->id;
       if ( $post_type == 'product' ) {
        // Define which meta boxes we wish to hide
        $hidden = array(
            'page-layout-mode',
            'page-layout',
            'page-content',
            'product-options',
            'custom-css-js',
            'product_branddiv',
            'aam-access-manager',
            'postcustom',
            'slugdiv',
            'sellerdiv',
            'molla-product-videos'
        );
        // Pass our new defaults onto WordPress
        return $hidden;
    }
    return $hidden;
}

function wpb_remove_screen_options() { 
    return false; 
}
add_filter('screen_options_show_screen', 'wpb_remove_screen_options');
define('DISALLOW_FILE_EDIT', true);