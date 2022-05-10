<?php
/**
 * Molla Elementor Custom Advanced Tab
 *
 * @version 1.3.0
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! class_exists( 'Molla_Widget_Advanced_Tabs' ) ) {
	/**
	 * Advanced Molla Motion Effects Tab
	 */
	class Molla_Widget_Advanced_Tabs {

		public $default_settings = array(
			'molla_advanced_scroll_effect'   => false,
			'molla_advanced_scroll_viewport' => 'centered',
			'molla_advanced_mouse_effect'    => false,
			'track_relative'                 => false,
			'track_direction'                => 'opposite',
			'track_speed'                    => array( 'size' => 1 ),
		);

		public $scroll_widget = array();

		public function __construct() {
			$this->init();
		}

		public function init() {

			add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'add_motion_effect_section' ), 10, 2 );

			add_action( 'elementor/frontend/widget/before_render', array( $this, 'widget_before_render' ) );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
		}

		public function enqueue_scripts() {
			if ( ! empty( $this->scroll_widgets ) ) {
				wp_enqueue_script( 'skrollr', MOLLA_JS . '/plugins/skrollr.min.js', array(), '0.6.30', true );
			}
			if ( ! empty( $this->track_widgets ) ) {
				wp_enqueue_script( 'jquery-parallax' );
			}
		}

		public function add_motion_effect_section( $self, $args ) {

			$self->start_controls_section(
				'widget_molla_motion_effects',
				array(
					'label' => esc_html__( 'Molla Motion Effects', 'molla-core' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				)
			);

			$this->register_scroll_effect_settings( $self );

			$this->register_mouse_effect_settings( $self );

			$self->end_controls_section();
		}

		public function register_scroll_effect_settings( $self ) {

			$self->add_control(
				'molla_advanced_scroll_effect',
				array(
					'label' => esc_html__( 'Scroll Effects', 'molla-core' ),
					'type'  => Controls_Manager::SWITCHER,
				)
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'scroll_effect',
				array(
					'label'       => esc_html__( 'Effect', 'molla-core' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => true,
					'default'     => 'Vertical',
					'options'     => array(
						'Vertical'     => esc_html__( 'Vertical Scroll', 'molla-core' ),
						'Horizontal'   => esc_html__( 'Horizontal Scroll', 'molla-core' ),
						'Transparency' => esc_html__( 'Transparency', 'molla-core' ),
						'Rotate'       => esc_html__( 'Rotate', 'molla-core' ),
						'Scale'        => esc_html__( 'Scale', 'molla-core' ),
					),
				)
			);

			$repeater->add_control(
				'v_direction',
				array(
					'label'     => esc_html__( 'Direction', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'up',
					'options'   => array(
						'up'     => esc_html__( 'Up', 'molla-core' ),
						'bottom' => esc_html__( 'Bottom', 'molla-core' ),
					),
					'condition' => array(
						'scroll_effect' => 'Vertical',
					),
				)
			);

			$repeater->add_control(
				'h_direction',
				array(
					'label'     => esc_html__( 'Direction', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => array(
						'left'  => esc_html__( 'To Left', 'molla-core' ),
						'right' => esc_html__( 'To Right', 'molla-core' ),
					),
					'condition' => array(
						'scroll_effect' => array( 'Horizontal', 'Rotate' ),
					),
				)
			);

			$repeater->add_control(
				't_direction',
				array(
					'label'     => esc_html__( 'Direction', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'in',
					'options'   => array(
						'in'  => esc_html__( 'Fade In', 'molla-core' ),
						'out' => esc_html__( 'Fade Out', 'molla-core' ),
					),
					'condition' => array(
						'scroll_effect' => 'Transparency',
					),
				)
			);

			$repeater->add_control(
				's_direction',
				array(
					'label'     => esc_html__( 'Direction', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'in',
					'options'   => array(
						'in'  => esc_html__( 'Scale Up', 'molla-core' ),
						'out' => esc_html__( 'Scale Down', 'molla-core' ),
					),
					'condition' => array(
						'scroll_effect' => 'Scale',
					),
				)
			);

			$repeater->add_control(
				'speed',
				array(
					'label'   => esc_html__( 'Speed', 'molla-core' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => array(
						'size' => 10,
					),
					'range'   => array(
						'px' => array(
							'min'  => 1,
							'max'  => 10,
							'step' => 1,
						),
					),
				)
			);

			$self->add_control(
				'molla_scroll_effects',
				array(
					'label'       => esc_html__( 'Effects', 'molla-core' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array(
							'scroll_effect' => 'Vertical',
							'v_direction'   => 'up',
							'speed'         => 3,
						),
					),
					'title_field' => '{{{scroll_effect}}}' . ' ' . esc_html__( 'Effect', 'molla-core' ),
					'condition'   => array(
						'molla_advanced_scroll_effect' => 'yes',
					),
				)
			);

			$self->add_control(
				'molla_advanced_scroll_viewport',
				array(
					'label'       => esc_html__( 'Viewport', 'molla-core' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => true,
					'default'     => 'centered',
					'options'     => array(
						'centered'      => esc_html__( 'Default', 'molla-core' ),
						'top_bottom'    => esc_html__( 'Top - Bottom', 'molla-core' ),
						'center_top'    => esc_html__( 'Center - Top', 'molla-core' ),
						'center_bottom' => esc_html__( 'Center - Bottom', 'molla-core' ),
					),
					'condition'   => array(
						'molla_advanced_scroll_effect' => 'yes',
					),
				)
			);
		}

		public function register_mouse_effect_settings( $self ) {

			$self->add_control(
				'molla_advanced_mouse_effect',
				array(
					'label'     => esc_html__( 'Mouse Track Effect', 'molla-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'separator' => 'before',
				)
			);

			$self->add_control(
				'track_relative',
				array(
					'label'     => esc_html__( 'Enable Relative', 'molla-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'no',
					'condition' => array(
						'molla_advanced_mouse_effect' => 'yes',
					),
				)
			);

			$self->add_control(
				'track_direction',
				array(
					'label'     => esc_html__( 'Direction', 'molla-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'opposite',
					'options'   => array(
						'opposite' => esc_html__( 'Opposite', 'molla-core' ),
						'direct'   => esc_html__( 'Direct', 'molla-core' ),
					),
					'condition' => array(
						'molla_advanced_mouse_effect' => 'yes',
					),
				)
			);

			$self->add_control(
				'track_speed',
				array(
					'label'     => esc_html__( 'Speed', 'molla-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 1,
					),
					'range'     => array(
						'' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 10,
						),
					),
					'condition' => array(
						'molla_advanced_mouse_effect' => 'yes',
					),
				)
			);
		}

		public function widget_before_render( $widget ) {
			$data     = $widget->get_data();
			$settings = $data['settings'];

			$settings = wp_parse_args( $settings, $this->default_settings );

			if ( filter_var( $settings['molla_advanced_scroll_effect'], FILTER_VALIDATE_BOOLEAN ) ) {
				$widget_settings = array();
				foreach ( $settings['molla_scroll_effects'] as $effect ) {
					$effect_name = isset( $effect['scroll_effect'] ) ? $effect['scroll_effect'] : 'Vertical';
					if ( 'Vertical' == $effect_name ) {
						$direction = isset( $effect['v_direction'] ) ? $effect['v_direction'] : 'up';
					} elseif ( 'Horizontal' == $effect_name || 'Rotate' == $effect_name ) {
						$direction = isset( $effect['h_direction'] ) ? $effect['h_direction'] : 'left';
					} elseif ( 'Transparency' == $effect_name ) {
						$direction = isset( $effect['t_direction'] ) ? $effect['t_direction'] : 'in';
					} elseif ( 'Scale' == $effect_name ) {
						$direction = isset( $effect['s_direction'] ) ? $effect['s_direction'] : 'in';
					}
					$speed = isset( $effect['speed'] ) ? $effect['speed']['size'] : 10;

					$widget_settings[ $effect_name ] = array(
						'direction' => $direction,
						'speed'     => $speed,
					);
				}
				$widget_settings['viewport'] = isset( $settings['molla_advanced_scroll_viewport'] ) ? $settings['molla_advanced_scroll_viewport'] : 'centered';

				$widget->add_render_attribute(
					'_wrapper',
					array(
						'class' => 'molla-motion-effect-widget molla-scroll-effect-widget',
					)
				);

				if ( ! empty( $widget_settings ) ) {
					$widget->add_render_attribute(
						'_wrapper',
						array(
							'data-molla-scroll-effect-settings' => json_encode( $widget_settings ),
						)
					);

					$this->scroll_widgets[] = $data['id'];
				}
			}

			if ( filter_var( $settings['molla_advanced_mouse_effect'], FILTER_VALIDATE_BOOLEAN ) ) {
				$widget_settings = array();
				if ( 'yes' == $settings['track_relative'] ) {
					$widget_settings['relativeInput']     = true;
					$widget_settings['clipRelativeInput'] = true;
				} else {
					$widget_settings['relativeInput']     = false;
					$widget_settings['clipRelativeInput'] = false;
				}
				if ( 'direct' == $settings['track_direction'] ) {
					$widget_settings['invertX'] = false;
					$widget_settings['invertY'] = false;
				} else {
					$widget_settings['invertX'] = true;
					$widget_settings['invertY'] = true;
				}

				$widget->add_render_attribute(
					'_wrapper',
					array(
						'class' => 'molla-motion-effect-widget molla-mouse-effect-widget floating-wrapper',
					)
				);

				if ( ! empty( $widget_settings ) ) {
					$widget->add_render_attribute(
						'_wrapper',
						array(
							'data-toggle'      => 'floating',
							'data-options'     => json_encode( $widget_settings ),
							'data-child-depth' => $settings['track_speed']['size'],
						)
					);

					$this->track_widgets[] = $data['id'];
				}
			}

		}
	}
	new Molla_Widget_Advanced_Tabs;
}
