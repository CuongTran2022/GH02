<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Molla_Controls_Manager;

function molla_el_grid_layout_controls( $self, $widget ) {
	$self->start_controls_section(
		'creative_layout_section',
		array(
			'label' => esc_html__( 'Creative Layout', 'molla-core' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		)
	);

	$self->add_responsive_control(
		'creative_cols',
		array(
			'type'           => Controls_Manager::SLIDER,
			'label'          => esc_html__( 'Columns', 'molla-core' ),
			'default'        => array(
				'size' => 4,
				'unit' => 'px',
			),
			'tablet_default' => array(
				'size' => 3,
				'unit' => 'px',
			),
			'mobile_default' => array(
				'size' => 2,
				'unit' => 'px',
			),
			'size_units'     => array(
				'px',
			),
			'range'          => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 60,
				),
			),
			'selectors'      => array(
				'.elementor-element-{{ID}} .creative-grid' => 'grid-template-columns: repeat(auto-fill, calc(100% / {{SIZE}}))',
			),
		)
	);

	$self->add_control(
		'spacing',
		array(
			'type'        => Controls_Manager::SLIDER,
			'label'       => esc_html__( 'Spacing (px)', 'molla-core' ),
			'description' => esc_html__( 'Leave blank if you use theme default value.', 'molla-core' ),
			'default'     => array(
				'size' => 20,
			),
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 40,
				),
			),
		)
	);
	/**
	 * Using Display Grid Css
	 */
	$repeater = new Repeater();

	$repeater->add_control(
		'item_no',
		[
			'label'       => esc_html__( 'Item Index', 'molla-core' ),
			'type'        => Controls_Manager::TEXT,
			'placeholder' => esc_html__( 'Blank for all items.', 'molla-core' ),
		]
	);

	$repeater->add_responsive_control(
		'item_col_span',
		array(
			'type'       => Controls_Manager::SLIDER,
			'label'      => esc_html__( 'Column Size', 'molla-core' ),
			'default'    => array(
				'size' => 1,
				'unit' => 'px',
			),
			'size_units' => array(
				'px',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 12,
				),
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-column-end: span {{SIZE}}',
			),
		)
	);

	$repeater->add_responsive_control(
		'item_row_span',
		array(
			'type'       => Controls_Manager::SLIDER,
			'label'      => esc_html__( 'Row Size', 'molla-core' ),
			'default'    => array(
				'size' => 1,
				'unit' => 'px',
			),
			'size_units' => array(
				'px',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 8,
				),
			),
			'selectors'  => array(
				'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-row-end: span {{SIZE}}',
			),
		)
	);

	$repeater->add_group_control(
		Group_Control_Image_Size::get_type(),
		array(
			'name'      => 'item_thumb', // Usage: `{name}_size` and `{name}_custom_dimension`
			'label'     => esc_html__( 'Image Size', 'molla-core' ),
			'default'   => 'woocommerce_single',
			'condition' => array(
				'item_no!' => '',
			),
		)
	);

	$self->add_control(
		'creative_layout_heading',
		array(
			'label'     => __( "Customize each grid item's layout", 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'items_list',
		[
			'label'       => esc_html__( 'Grid Item Layouts', 'molla-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => array(
				array(
					'item_no'       => '',
					'item_col_span' => array(
						'size' => 1,
						'unit' => 'px',
					),
					'item_row_span' => array(
						'size' => 1,
						'unit' => 'px',
					),
				),
				array(
					'item_no'       => 1,
					'item_col_span' => array(
						'size' => 2,
						'unit' => 'px',
					),
					'item_row_span' => array(
						'size' => 1,
						'unit' => 'px',
					),
				),
			),
			'title_field' => sprintf( '{{{ item_no ? \'%1$s\' : \'%2$s\' }}}' . ' <strong>{{{ item_no }}}</strong>', esc_html__( 'Index', 'molla-core' ), esc_html__( 'Base', 'molla-core' ) ),
		]
	);

	$self->add_responsive_control(
		'creative_equal_height',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => esc_html__( 'Different Row Height', 'molla-core' ),
			'default'   => 'yes',
			'separator' => 'after',
			'selectors' => array(
				'.elementor-element-{{ID}} .creative-grid' => 'grid-auto-rows: auto',
			),
		)
	);

	$self->end_controls_section();
}
