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

class Molla_Elementor_Product_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_product';
	}

	public function get_title() {
		return esc_html__( 'Products', 'molla-core' );
	}

	public function get_icon() {
		return 'molla-elementor-widget-icon eicon-products';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce' );
	}

	public function get_script_depends() {
		$scripts = array( 'owl-carousel', 'isotope-pkgd', 'jquery-hoverIntent', 'bootstrap-input-spinner' );
		if ( molla_is_elementor_preview() ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		molla_el_products_select_controls( $this );
		molla_el_products_layout_controls( $this );
		molla_el_products_type_controls( $this );
		molla_el_products_style_controls( $this );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product.php';
	}
}

