<?php
/**
 * Plugin Name: sales-by-school
 * Version:      1.0.0
 * Author:     zdtz
 * Description:  add analaytic sale by school 
 * @package WooCommerce\Admin
 */

/**
 * Register the JS.
 */
 	$column_types = array(
		'school' => 'string',
		'schoold_id'    => 'int',
		'items_sold'     => 'int',
		'net_revenue'    => 'float',
		'orders_count'   => 'int',
		'products_count' => 'int',
		'total_item_sold'     => 'int',
		'total_net_revenue'    => 'float',
		'total_orders_count'   => 'int',
		'total_schools_count' => 'int'
	);

function add_sale_by_school_register_script() {
	if ( ! class_exists( 'Automattic\WooCommerce\Admin\Loader' ) || ! \Automattic\WooCommerce\Admin\Loader::is_admin_or_embed_page() ) {
		return;
	}
	
	$script_path       = '/build/index.js';
	$script_asset_path = dirname( __FILE__ ) . '/build/index.asset.php';
	$script_asset      = file_exists( $script_asset_path )
		? require( $script_asset_path )
		: array( 'dependencies' => array(), 'version' => filemtime( $script_path ) );
	$script_url = plugins_url( $script_path, __FILE__ );

	wp_register_script(
		'sale-by-school',
		$script_url,
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);

	wp_register_style(
		'sale-by-school',
		plugins_url( '/build/index.css', __FILE__ ),
		// Add any dependencies styles may have, such as wp-components.
		array(),
		filemtime( dirname( __FILE__ ) . '/build/index.css' )
	);

	wp_enqueue_script( 'sale-by-school' );
	wp_enqueue_style( 'sale-by-school' );
}

add_action( 'admin_enqueue_scripts', 'add_sale_by_school_register_script' );


add_filter( 'woocommerce_analytics_report_menu_items', 'add_sale_by_school_to_analytics_menu' );
function add_sale_by_school_to_analytics_menu( $report_pages ) {
    $report_pages[] = array(
        'id' => 'sale-by-school',
        'title' => __('Trường học', 'sale-by-school'),
        'parent' => 'woocommerce-analytics',
        'path' => '/analytics/sale-by-school'
    );
    return $report_pages;
}

function cast_numbers($arrayparam) {
	$resultarr = array();
	global $column_types;
	foreach ($arrayparam as $key => $value) {
			if(array_key_exists($key, $column_types)){
					settype($value, $column_types[$key]);
					$resultarr[$key] = $value;
			}
	}
	return $resultarr;
};

function cast_numbers_object($obj) {
	$resultObj = (object)[];
	global $column_types;
	foreach ($obj as $key => $value) {
			if(array_key_exists($key, $column_types)){
					settype($value, $column_types[$key]);
					$resultObj->$key = $value;
			}
	}
	return $resultObj;
};

function count_order($arr) {
	$sum = 0;
	foreach($arr as $key=>$value){
		if(isset($value->orders_count))
			$sum += settype($value->orders_count, "int");
	}
	return $sum;
}

function page_records( $data, $page_no, $items_per_page ) {
	$offset = ( $page_no - 1 ) * $items_per_page;
	return array_slice( $data, $offset, $items_per_page );
};

function get_sum_sale_by_school( $before, $after ) {
	global $wpdb;
	$query = "
		SELECT
				SUM(product_qty) as total_item_sold, 
				SUM(product_net_revenue) AS total_net_revenue, 
				COUNT(DISTINCT pl.order_id) as total_orders_count,
				COUNT(DISTINCT tt.term_id) as total_schools_count
		FROM
				{$wpdb->prefix}wc_order_product_lookup as pl
				JOIN {$wpdb->prefix}wc_order_stats as os ON pl.order_id = os.order_id 
				LEFT JOIN {$wpdb->prefix}term_relationships as tr ON pl.product_id = tr.object_id 
				JOIN {$wpdb->prefix}term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id AND tt.taxonomy = 'pwb-brand'  
				LEFT JOIN {$wpdb->prefix}terms as t ON t.term_id = tt.term_id
		WHERE
				1=1
				AND ( os.status NOT IN ( 'wc-trash','wc-pending','wc-failed','wc-cancelled' ) ) AND pl.date_created <= %s AND pl.date_created >= %s
	";

	$results = $wpdb->get_row( $wpdb->prepare( $query, $before, $after ) );

	$results = cast_numbers_object($results);

	return $results;
}

function my_awesome_func( WP_REST_Request $request ) {

	// You can get the combined, merged set of parameters:
	$parameters = $request->get_params();
 


		$posts = get_posts( array(
		'author' => $data['id'],
	) );
 
	if ( empty( $posts ) ) {
		return new WP_Error( 'no_author', 'Invalid author', array( 'status' => 404 ) );
	}

	$data = (object) array(
			'data'    => array(),
			'total'   => 0,
			'pages'   => 0,
			'page_no' => 0,
	);
	global $wpdb;
	$query = "
		SELECT
				t.term_id as schoold_id, 
				t.name as school,  
				SUM(product_qty) as items_sold, 
				SUM(product_net_revenue) AS net_revenue, 
				COUNT(DISTINCT pl.order_id) as orders_count, 
				COUNT(DISTINCT pl.product_id) as products_count
		FROM
				{$wpdb->prefix}wc_order_product_lookup as pl
				JOIN {$wpdb->prefix}wc_order_stats as os ON pl.order_id = os.order_id 
				LEFT JOIN {$wpdb->prefix}term_relationships as tr ON pl.product_id = tr.object_id 
				JOIN {$wpdb->prefix}term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id AND tt.taxonomy = 'pwb-brand'  
				LEFT JOIN {$wpdb->prefix}terms as t ON t.term_id = tt.term_id
		WHERE
				1=1
				AND ( os.status NOT IN ( 'wc-trash','wc-pending','wc-failed','wc-cancelled' ) ) AND pl.date_created <= %s AND pl.date_created >= %s
		GROUP by schoold_id
		ORDER by net_revenue DESC
	";

	$results = (array) $wpdb->get_results( $wpdb->prepare( $query, $parameters['before'], $parameters['after'] ), ARRAY_A );
	$sum_results = get_sum_sale_by_school($parameters['before'], $parameters['after']);

	if ( null === $results ) {
		return new \WP_Error( 'woocommerce_analytics_categories_result_failed', __( 'Sorry, fetching revenue data failed.', 'woocommerce-admin' ), array( 'status' => 500 ) );
	}elseif (null === $sum_results) {
		return new \WP_Error( 'woocommerce_analytics_categories_result_failed', __( 'Sorry, fetching revenue data failed.', 'woocommerce-admin' ), array( 'status' => 500 ) );
	}

	$record_count = count( $results );
	$results = array_map( 'cast_numbers', $results );

	$total_pages  = (int) ceil( $record_count / $parameters['per_page'] );
	// if ( $parameters['page'] < 1 || $parameters['page'] > $total_pages ) {
	// 	return $data;
	// } TODO: caching data

	$results = page_records( $results, $parameters['page'], $parameters['per_page'] );
	$data            = (object) array(
		'data'    => $results,
		'total'   => $record_count,
		'pages'   => $total_pages,
		'pageIndex' => (int) $parameters['page'],
		'total_item_sold' => $sum_results->total_item_sold,
		'total_net_revenue' => $sum_results->total_net_revenue,
		'totalOrders' => $sum_results->total_orders_count,
		'total_schools_count' => $sum_results->total_schools_count
	);
	return $data;
};

add_action( 'rest_api_init', function () {
	register_rest_route( 'sale-by-school/v1', '/reports/schools', array(
		'methods' => 'GET',
		'callback' => 'my_awesome_func',
		// 'args' => array(
		//   'id' => array(
		//     'validate_callback' => function($param, $request, $key) {
		//       return is_numeric( $param );
		//     }
		//   ),
		// ),
	) );
} );


