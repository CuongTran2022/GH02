<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Molla Elementor Products Widget
 *
 * Molla Elementor widget to display products.
 *
 * @since 1.0
 */

class Molla_Elementor_Product_Banner_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_product_banner';
	}

	public function get_title() {
		return esc_html__( 'Products + Banner', 'molla-core' );
	}

	public function get_icon() {
		return 'molla-elementor-widget-icon eicon-products';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce', 'banner' );
	}

	public function get_script_depends() {
		$scripts = array( 'owl-carousel', 'jquery-hoverIntent' );
		if ( molla_is_elementor_preview() ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {
		// Banner Controls
		molla_el_banner_content_controls( $this, false );
		molla_el_banner_style_controls( $this, false );

		molla_el_grid_layout_controls( $this, 'product' );

		// Product Controls
		molla_el_products_select_controls( $this, false );
		molla_el_products_type_controls( $this );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product_banner.php';
	}
}

