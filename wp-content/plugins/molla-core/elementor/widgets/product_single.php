<?php
defined( 'ABSPATH' ) || die;

/**
 * molla Single Product Widget
 *
 * molla Widget to display products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Molla_Elementor_Product_Single_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'molla_single_product';
	}

	public function get_title() {
		return esc_html__( 'Single Product', 'molla-core' );
	}

	public function get_icon() {
		return 'molla-elementor-widget-icon eicon-single-product';
	}

	public function get_categories() {
		return array( 'molla-elements' );
	}

	public function get_keywords() {
		return array( 'single', 'product', 'flipbook', 'lookbook', 'carousel', 'slider', 'shop', 'woocommerce' );
	}

	public function get_style_depends() {
		return array();
	}

	public function get_script_depends() {
		$scripts = array( 'wc-single-product', 'wc-add-to-cart-variation' );
		if ( molla_is_elementor_preview() ) {
			$scripts[] = 'molla-elementor-widgets-js';
		}
		return $scripts;
	}

	protected function _register_controls() {

		molla_el_products_select_controls( $this, false, false );

		$this->start_controls_section(
			'section_single_product',
			array(
				'label' => esc_html__( 'Single Product', 'molla-core' ),
			)
		);

			$this->add_control(
				'sp_title_tag',
				array(
					'label'   => esc_html__( 'Title Tag', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					),
					'default' => 'h2',
				)
			);

			$this->add_control(
				'sp_gallery_type',
				array(
					'label'   => esc_html__( 'Gallery Type', 'molla-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''           => esc_html__( 'Default', 'molla-core' ),
						'vertical'   => esc_html__( 'Vertical', 'molla-core' ),
						'horizontal' => esc_html__( 'Horizontal', 'molla-core' ),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'thumbnail',
					'default'   => 'woocommerce_thumbnail',
					'separator' => 'none',
				)
			);

			$this->add_control(
				'sp_show_thumbnail',
				array(
					'label'   => esc_html__( 'Show Thumbnails', 'molla-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

			$this->add_control(
				'sp_show_info',
				array(
					'type'     => Controls_Manager::SELECT2,
					'label'    => esc_html__( 'Show Information', 'molla-core' ),
					'multiple' => true,
					'default'  => array( 'title', 'meta', 'price', 'rating', 'excerpt', 'addtocart_form', 'countdown' ),
					'options'  => array(
						'title'          => esc_html__( 'Title', 'molla-core' ),
						'meta'           => esc_html__( 'Meta', 'molla-core' ),
						'price'          => esc_html__( 'Price', 'molla-core' ),
						'rating'         => esc_html__( 'Rating', 'molla-core' ),
						'excerpt'        => esc_html__( 'Description', 'molla-core' ),
						'addtocart_form' => esc_html__( 'Add To Cart Form', 'molla-core' ),
						'countdown'      => esc_html__( 'Countdown', 'molla-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'col_cnt',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Columns', 'molla-core' ),
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'molla-core' ),
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_cnt_xl',
				array(
					'label'     => esc_html__( 'Columns ( >= 1200px )', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'molla-core' ),
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_cnt_min',
				array(
					'label'     => esc_html__( 'Columns ( < 576px )', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'molla-core' ),
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_sp',
				array(
					'label'     => esc_html__( 'Spacing', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'md',
					'options'   => array(
						'no' => esc_html__( 'No space', 'molla-core' ),
						'xs' => esc_html__( 'Extra Small', 'molla-core' ),
						'sm' => esc_html__( 'Small', 'molla-core' ),
						'md' => esc_html__( 'Medium', 'molla-core' ),
						'lg' => esc_html__( 'Large', 'molla-core' ),
					),
					'condition' => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sp_style',
			array(
				'label' => esc_html__( 'Single Product', 'wolmart-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'product_summary_height',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Summary Max Height', 'wolmart-core' ),
					'size_units' => array( 'px', 'rem', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .single-products .product .summary' => 'max-height: {{SIZE}}{{UNIT}}; overflow-y: auto; overflow-x: hidden;',
					),
				)
			);

			$this->start_controls_tabs(
				'sp_tabs',
				array(
					'separator' => 'before',
				)
			);

				$this->start_controls_tab(
					'sp_title_tab',
					array(
						'label' => esc_html__( 'Title', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_title_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .single-products .product .product_title' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'sp_title_typo',
							'scheme'   => Typography::TYPOGRAPHY_1,
							'selector' => '.elementor-element-{{ID}} .product_title',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_price_tab',
					array(
						'label' => esc_html__( 'Price', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_price_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .single-products .product p.price ins' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'sp_price_typo',
							'scheme'   => Typography::TYPOGRAPHY_1,
							'selector' => '.elementor-element-{{ID}} .single-products .product p.price',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_old_price_tab',
					array(
						'label' => esc_html__( 'Old Price', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_old_price_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .single-products .product .price del' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'sp_old_price_typo',
							'scheme'   => Typography::TYPOGRAPHY_1,
							'selector' => '.elementor-element-{{ID}} .single-products .product .price del',
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'style_heading_countdown',
				array(
					'label'     => esc_html__( 'Countdown', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'sp_countdown_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .single-products .product .countdown-section' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'sp_countdown_br_color',
				array(
					'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .single-products .product .countdown-section' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'style_cart_button',
				array(
					'label'     => esc_html__( 'Add To Cart Button', 'wolmart-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->start_controls_tabs( 'sp_cart_tabs' );

				$this->start_controls_tab(
					'sp_cart_btn_tab',
					array(
						'label' => esc_html__( 'Default', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_cart_btn_bg',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .single-products .product form.cart .single_add_to_cart_button' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_cart_btn_border',
						array(
							'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .single-products .product form.cart .single_add_to_cart_button' => 'border-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_cart_btn_color',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .single-products .product form.cart .single_add_to_cart_button' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_cart_btn_tab_hover',
					array(
						'label' => esc_html__( 'Hover', 'wolmart-core' ),
					)
				);

					$this->add_control(
						'sp_cart_btn_bg_hover',
						array(
							'label'     => esc_html__( 'Background Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .single-products .product form.cart .single_add_to_cart_button:not(.disabled):hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_cart_btn_border_hover',
						array(
							'label'     => esc_html__( 'Border Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .single-products .product form.cart .single_add_to_cart_button:not(.disabled):hover' => 'border-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'sp_cart_btn_color_hover',
						array(
							'label'     => esc_html__( 'Color', 'wolmart-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .single-products .product form.cart .single_add_to_cart_button:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_cart_btn_typo',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} .single-products .product form.cart .single_add_to_cart_button',
				)
			);

		$this->end_controls_section();

		molla_el_single_product_layout( $this );

		molla_el_slider_style_controls( $this );
	}

	public function before_render() {
		// Add `elementor-widget-theme-post-content` class to avoid conflicts that figure gets zero margin.
		$this->add_render_attribute(
			array(
				'_wrapper' => array(
					'class' => 'elementor-widget-theme-post-content',
				),
			)
		);

		parent::before_render();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include MOLLA_ELEMENTOR_TEMPLATES . 'molla_product_single.php';
	}

	protected function content_template() {}
}
