<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Molla Banner Widget
 *
 * Molla Widget to display banner.
 *
 * @since 1.1
 */


class Molla_Elementor_Banner_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_banner';
	}

	public function get_title() {
		return esc_html__( 'Banner', 'molla-core' );
	}

	public function get_icon() {
		return 'molla-elementor-widget-icon eicon-banner';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'banner' );
	}

	public function get_script_depends() {
		$scripts = array();
		if ( molla_is_elementor_preview() ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}


	protected function _register_controls() {
		molla_el_banner_content_controls( $this );
		molla_el_banner_style_controls( $this );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'title' );

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_banner.php';
	}

	public function before_render() {
		// Lazyload background image
		$atts = $this->get_settings_for_display();
		if ( 'yes' == $atts['banner_stretch'] ) {
			$this->add_render_attribute( '_wrapper', 'class', 'elementor-widget-molla_stretch_banner' );
		}
		?>
		<div <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
		<?php
	}
}
