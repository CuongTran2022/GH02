<?php
defined( 'ABSPATH' ) || die;

/**
 * molla Products Banner Widget Render
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'banner_insert'        => '',
			'creative_cols'        => '',
			'creative_cols_tablet' => '',
			'creative_cols_mobile' => '',
			'items_list'           => '',
		),
		$atts
	)
);

if ( is_array( $items_list ) ) {
	$repeater_ids = array();
	foreach ( $items_list as $item ) {
		$repeater_ids[ (int) $item['item_no'] ] = 'elementor-repeater-item-' . $item['_id'];
	}
	wc_set_loop_prop( 'repeater_ids', $repeater_ids );
}
$GLOBALS['molla_loop_index'] = 1;

// Banner html
ob_start();
include MOLLA_ELEMENTOR_TEMPLATES . 'molla_banner.php';
$banner_html = ob_get_clean();

wc_set_loop_prop( 'product_banner', $banner_html );
wc_set_loop_prop( 'banner_insert', $banner_insert );

include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product.php';

if ( isset( $GLOBALS['molla_loop_index'] ) ) {
	unset( $GLOBALS['molla_loop_index'] );
}
