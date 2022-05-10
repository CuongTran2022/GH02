<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use ELementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Molla_Controls_Manager;

// Product Select Controls
function molla_el_products_select_controls( $self, $full = true, $others = true ) {
	$self->start_controls_section(
		'section_products',
		array(
			'label' => esc_html__( 'Products Selector', 'molla-core' ),
		)
	);

	if ( $full ) {
		$self->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( 'Title', 'molla-core' ),
			)
		);

		$self->add_control(
			'title_link',
			array(
				'label' => esc_html__( 'Title Link', 'molla-core' ),
				'type'  => Controls_Manager::URL,
			)
		);

		$self->add_control(
			'desc',
			array(
				'label'       => esc_html__( 'Description', 'molla-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'placeholder' => esc_html__( 'Description', 'molla-core' ),
			)
		);

		$self->add_responsive_control(
			'title_align',
			array(
				'label'     => esc_html__( 'Alignment', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'molla-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .title-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);
	}

	$self->add_control(
		'status',
		array(
			'label'   => esc_html__( 'Product Status', 'molla-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''          => esc_html__( 'All', 'molla-core' ),
				'featured'  => esc_html__( 'Featured', 'molla-core' ),
				'on_sale'   => esc_html__( 'On Sale', 'molla-core' ),
				'pre_order' => esc_html__( 'Pre-Ordered', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		'ids',
		array(
			'label'       => esc_html__( 'Select products', 'molla-core' ),
			'type'        => Molla_Controls_Manager::AJAXSELECT2,
			'options'     => 'product',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'category',
		array(
			'label'       => esc_html__( 'Select categories', 'molla-core' ),
			'type'        => Molla_Controls_Manager::AJAXSELECT2,
			'options'     => 'product_cat',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'brands',
		array(
			'label'       => esc_html__( 'Select Brands', 'molla-core' ),
			'type'        => Molla_Controls_Manager::AJAXSELECT2,
			'options'     => 'product_brand',
			'label_block' => true,
			'multiple'    => 'true',
		)
	);

	$self->add_control(
		'count',
		array(
			'type'    => Controls_Manager::SLIDER,
			'label'   => esc_html__( 'Products Count Per Page', 'molla-core' ),
			'default' => array(
				'size' => $full ? 4 : 6,
			),
			'range'   => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
			),
		)
	);

	$self->add_control(
		'orderby',
		array(
			'type'    => Controls_Manager::SELECT,
			'label'   => esc_html__( 'Order by', 'molla-core' ),
			'options' => array(
				'',
				'title'          => esc_html__( 'Title', 'molla-core' ),
				'ID'             => esc_html__( 'ID', 'molla-core' ),
				'date'           => esc_html__( 'Date', 'molla-core' ),
				'modified'       => esc_html__( 'Modified', 'molla-core' ),
				'rand'           => esc_html__( 'Random', 'molla-core' ),
				'comment_count'  => esc_html__( 'Comment count', 'molla-core' ),
				'popularity'     => esc_html__( 'Total Sales', 'molla-core' ),
				'rating'         => esc_html__( 'Rating', 'molla-core' ),
				'sale_date_to'   => esc_html__( 'Sale End Date', 'molla-core' ),
				'sale_date_from' => esc_html__( 'Sale Start Date', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		'order',
		array(
			'type'    => Controls_Manager::SELECT,
			'label'   => esc_html__( 'Order way', 'molla-core' ),
			'options' => array(
				'',
				'DESC' => esc_html__( 'Descending', 'molla-core' ),
				'ASC'  => esc_html__( 'Ascending', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		'order_from',
		array(
			'label'       => esc_html__( 'Date From', 'molla-core' ),
			'description' => esc_html__( 'Start date that the ordering will be applied', 'molla-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''       => '',
				'today'  => esc_html__( 'Today', 'molla-core' ),
				'week'   => esc_html__( 'This Week', 'molla-core' ),
				'month'  => esc_html__( 'This Month', 'molla-core' ),
				'year'   => esc_html__( 'This Year', 'molla-core' ),
				'custom' => esc_html__( 'Custom', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		'order_from_date',
		array(
			'label'     => esc_html__( 'Date', 'molla-core' ),
			'type'      => Controls_Manager::DATE_TIME,
			'default'   => '',
			'condition' => array(
				'order_from' => 'custom',
			),
		)
	);

	$self->add_control(
		'order_to',
		array(
			'label'       => esc_html__( 'Date To', 'molla-core' ),
			'description' => esc_html__( 'End date that the ordering will be applied', 'molla-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''       => '',
				'today'  => esc_html__( 'Today', 'molla-core' ),
				'week'   => esc_html__( 'This Week', 'molla-core' ),
				'month'  => esc_html__( 'This Month', 'molla-core' ),
				'year'   => esc_html__( 'This Year', 'molla-core' ),
				'custom' => esc_html__( 'Custom', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		'order_to_date',
		array(
			'label'     => esc_html__( 'ytr eqDate', 'molla-core' ),
			'type'      => Controls_Manager::DATE_TIME,
			'default'   => '',
			'condition' => array(
				'order_to' => 'custom',
			),
		)
	);

	if ( $others ) {
		$self->add_control(
			'hide_out_date',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Hide Product Out of Date', 'molla-core' ),
			)
		);

		$self->add_control(
			'total_sales',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Total sales', 'molla-core' ),
				'options' => array(
					''        => esc_html__( 'Hide', 'molla-core' ),
					'count'   => esc_html__( 'Only count', 'molla-core' ),
					'percent' => esc_html__( 'Percentage of max', 'molla-core' ),
				),
			)
		);
	}

	$self->end_controls_section();
}

function molla_el_products_layout_controls( $self, $full = true, $grid = false ) {
	$self->start_controls_section(
		'section_products_layout',
		array(
			'label' => esc_html__( 'Products Layout', 'molla-core' ),
		)
	);

	if ( ! $grid ) {
		$self->add_control(
			'layout_mode',
			array(
				'label'   => esc_html__( 'Layout Mode', 'molla-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__( 'Grid', 'molla-core' ),
					'creative' => esc_html__( 'Grid - Creative', 'molla-core' ),
					'slider'   => esc_html__( 'Slider', 'molla-core' ),
				),
			)
		);
	}

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

	if ( ! $grid ) {
		$self->add_control(
			'cols_upper_desktop',
			array(
				'label'     => esc_html__( 'Columns Upper Desktop ( >= 1200px )', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''  => esc_html__( 'Default', 'molla-core' ),
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
				),
				'condition' => array(
					'layout_mode!'   => array( 'creative' ),
					'product_style!' => array( 'list' ),
				),
			)
		);
	}

	$self->add_responsive_control(
		'columns',
		array(
			'type'      => Controls_Manager::SELECT,
			'label'     => esc_html__( 'Columns', 'molla-core' ),
			'default'   => '4',
			'options'   => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
			),
			'condition' => array(
				'product_style!' => array( 'list' ),
			),
		)
	);

	if ( ! $grid ) {
		$self->add_control(
			'cols_under_mobile',
			array(
				'label'     => esc_html__( 'Columns Under Mobile ( <= 575px )', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 2,
				'options'   => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
				),
				'condition' => array(
					'product_style!' => array( 'list' ),
				),
			)
		);
		$self->add_control(
			'product_slider_heading',
			array(
				'label'     => esc_html__( 'Slider Options', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$self->add_control(
			'product_slider_nav_pos',
			array(
				'label'     => esc_html__( 'Nav & Dot Position', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					'owl-nav-inside' => esc_html__( 'Inner', 'molla-core' ),
					''               => esc_html__( 'Outer', 'molla-core' ),
					'owl-nav-top'    => esc_html__( 'Top', 'molla-core' ),
				),
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$self->add_control(
			'product_slider_nav_type',
			array(
				'label'     => esc_html__( 'Nav Type', 'molla-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''                => esc_html__( 'Type 1', 'molla-core' ),
					'owl-full'        => esc_html__( 'Type 2', 'molla-core' ),
					'owl-nav-rounded' => esc_html__( 'Type 3', 'molla-core' ),
				),
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$self->add_responsive_control(
			'slider_nav',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show navigation?', 'molla-core' ),
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$self->add_control(
			'slider_nav_show',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Enable Navigation Auto Hide', 'molla-core' ),
				'default'   => 'yes',
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$self->add_responsive_control(
			'slider_dot',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show slider dots?', 'molla-core' ),
				'condition' => array(
					'layout_mode' => array( 'slider' ),
				),
			)
		);

		$self->add_control(
			'slider_loop',
			array(
				'label'     => esc_html__( 'Enable Loop', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'layout_mode' => 'slider',
				),
			)
		);

		$self->add_control(
			'slider_auto_play',
			array(
				'label'     => esc_html__( 'Enable Auto-Play', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'layout_mode' => 'slider',
				),
			)
		);

		$self->add_control(
			'slider_auto_play_time',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'molla-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 10000,
				'condition' => array(
					'layout_mode'      => 'slider',
					'slider_auto_play' => 'yes',
				),
			)
		);

		$self->add_control(
			'slider_center',
			array(
				'label'     => esc_html__( 'Enable Center Mode', 'molla-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => array(
					'layout_mode' => 'slider',
				),
			)
		);

		$self->add_control(
			'products_align',
			array(
				'label'     => esc_html__( 'Align', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'molla-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .products' => 'justify-content: {{VALUE}};',
				),
				'condition' => array(
					'layout_mode' => array(
						'grid',
					),
				),
			)
		);
	}

	if ( $full ) {
		$self->add_control(
			'product_filter_heading',
			array(
				'label'     => esc_html__( 'Filter Options', 'molla-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_control(
			'filter',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Filter By Category', 'molla-core' ),
			)
		);

		$self->add_control(
			'hide_all_cat',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Hide \'All\'', 'molla-core' ),
				'condition' => array(
					'filter' => array( 'yes' ),
				),
			)
		);

		$self->add_control(
			'hide_empty_cat',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Hide Empty Category', 'molla-core' ),
				'condition' => array(
					'filter' => array( 'yes' ),
				),
			)
		);

		$self->add_control(
			'title_pos',
			array(
				'label'     => esc_html__( 'Title Wrap Position', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => array(
					'left'  => array(
						'title' => esc_html__( 'Left Side', 'molla-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right Side', 'molla-core' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'condition' => array(
					'filter' => array( 'yes' ),
				),
			)
		);

		$self->add_control(
			'filter_pos',
			array(
				'label'     => esc_html__( 'Filter Position', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'bottom',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'top'    => array(
						'title' => esc_html__( 'Top', 'molla-core' ),
						'icon'  => 'eicon-v-align-top',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-h-align-right',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'molla-core' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'condition' => array(
					'filter' => array( 'yes' ),
				),
				'toggle'    => false,
			)
		);

		$self->add_control(
			'title_bg',
			[
				'label'     => esc_html__( 'Choose Background Image for Heading', 'molla-core' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => array(
					'title_pos!' => array( '' ),
				),
				'selectors' => [
					'{{WRAPPER}} .heading' => 'background: no-repeat url("{{URL}}") 50% 50%; background-size: cover;',
				],
			]
		);

		$self->add_responsive_control(
			'filter_align',
			array(
				'label'     => esc_html__( 'Filter Align', 'molla-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'molla-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'molla-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'molla-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'condition' => array(
					'filter' => array( 'yes' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .nav-filter' => 'justify-content: {{VALUE}};',
				),
			)
		);
	}

	$self->add_control(
		'product_extra_heading',
		array(
			'label'     => esc_html__( 'Extra Options', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'load_more',
		array(
			'label'     => esc_html__( 'Ajax Load More', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => array(
				''       => esc_html__( 'Do not load more', 'molla-core' ),
				'button' => esc_html__( 'View More Button', 'molla-core' ),
				'scroll' => esc_html__( 'Infinite Scroll', 'molla-core' ),
			),
			'condition' => array(
				'layout_mode!' => 'slider',
			),
		)
	);

	$self->add_control(
		'view_more_label',
		array(
			'label'       => esc_html__( 'Button Label', 'molla-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'View More Products', 'molla-core' ),
			'condition'   => array(
				'layout_mode!' => 'slider',
				'load_more'    => 'button',
			),
		)
	);

	$self->add_control(
		'view_more_icon',
		array(
			'label'     => esc_html__( 'Icon', 'molla-core' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => array(
				'value'   => 'icon-long-arrow-down',
				'library' => '',
			),
			'condition' => array(
				'layout_mode!' => 'slider',
				'load_more'    => 'button',
			),
		)
	);

	$self->add_control(
		'view_more_icon_space',
		array(
			'label'     => esc_html__( 'Icon Spacing', 'molla-core' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 30,
				),
			),
			'selectors' => array(
				'{{WRAPPER}} .more-product i' => 'margin-left: {{SIZE}}px;',
			),
			'condition' => array(
				'layout_mode!' => 'slider',
				'load_more'    => 'button',
			),
		)
	);

	$self->add_control(
		'view_more_icon_size',
		array(
			'label'     => esc_html__( 'Icon Size', 'molla-core' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 50,
				),
			),
			'selectors' => array(
				'{{WRAPPER}} .more-product i' => 'font-size: {{SIZE}}px;',
			),
			'condition' => array(
				'layout_mode!' => 'slider',
				'load_more'    => 'button',
			),
		)
	);

	$self->add_control(
		'product_border',
		array(
			'type'  => Controls_Manager::SWITCHER,
			'label' => esc_html__( 'Enable Split Line', 'molla-core' ),
		)
	);

	$self->end_controls_section();
}

function molla_el_products_type_controls( $self ) {
	$self->start_controls_section(
		'section_products_type',
		array(
			'label' => esc_html__( 'Products Type', 'molla-core' ),
		)
	);

	$self->add_control(
		'type',
		array(
			'label'   => esc_html__( 'Type', 'molla-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''       => esc_html__( 'Theme Options', 'molla-core' ),
				'custom' => esc_html__( 'Custom', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		'product_style',
		array(
			'label'     => esc_html__( 'Product Type', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'default',
			'options'   => array(
				'default'       => esc_html__( 'Default', 'molla-core' ),
				'classic'       => esc_html__( 'Classic', 'molla-core' ),
				'simple'        => esc_html__( 'Simple', 'molla-core' ),
				'popup'         => esc_html__( 'Popup 1', 'molla-core' ),
				'no-overlay'    => esc_html__( 'Popup 2', 'molla-core' ),
				'slide'         => esc_html__( 'Slide Over', 'molla-core' ),
				'light'         => esc_html__( 'Light', 'molla-core' ),
				'dark'          => esc_html__( 'Dark', 'molla-core' ),
				'list'          => esc_html__( 'List', 'molla-core' ),
				'card'          => esc_html__( 'Card', 'molla-core' ),
				'widget'        => esc_html__( 'Widget', 'molla-core' ),
				'full'          => esc_html__( 'Banner-Type', 'molla-core' ),
				'gallery-popup' => esc_html__( 'Gallery-Type', 'molla-core' ),
			),
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_responsive_control(
		'product_align',
		array(
			'label'     => esc_html__( 'Product Align', 'molla-core' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'center',
			'options'   => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'molla-core' ),
					'icon'  => 'eicon-text-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'molla-core' ),
					'icon'  => 'eicon-text-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'molla-core' ),
					'icon'  => 'eicon-text-align-right',
				),
			),
			'condition' => array(
				'type'           => 'custom',
				'product_style!' => 'card',
			),
		)
	);

	$self->add_control(
		'prod_t_x_pos',
		array(
			'label'     => esc_html__( 'X Align', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'center',
			'options'   => array(
				'left'   => esc_html__( 'Default', 'molla-core' ),
				'center' => esc_html__( 'Center', 'molla-core' ),
			),
			'condition' => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->add_control(
		'prod_t_y_pos',
		array(
			'label'     => esc_html__( 'Y Align', 'molla-core' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'center',
			'options'   => array(
				'top'    => esc_html__( 'Default', 'molla-core' ),
				'center' => esc_html__( 'Center', 'molla-core' ),
			),
			'condition' => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);
	$self->start_controls_tabs( 'tabs_position' );

	$self->start_controls_tab(
		'tab_pos_top',
		array(
			'label'     => esc_html__( 'Top', 'molla-core' ),
			'condition' => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->add_responsive_control(
		'body_pos_top',
		array(
			'label'      => esc_html__( 'Top', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => array(
				'size' => 50,
				'unit' => '%',
			),
			'size_units' => array(
				'px',
				'%',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 500,
				),
				'%'  => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-body' => 'top: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_pos_right',
		array(
			'label'     => esc_html__( 'Right', 'molla-core' ),
			'condition' => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->add_responsive_control(
		'body_pos_right',
		array(
			'label'      => esc_html__( 'Right', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array(
				'px',
				'%',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 500,
				),
				'%'  => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-body' => 'right: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_pos_bottom',
		array(
			'label'     => esc_html__( 'Bottom', 'molla-core' ),
			'condition' => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->add_responsive_control(
		'body_pos_bottom',
		array(
			'label'      => esc_html__( 'Bottom', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array(
				'px',
				'%',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 500,
				),
				'%'  => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-body' => 'bottom: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_pos_left',
		array(
			'label'     => esc_html__( 'Left', 'molla-core' ),
			'condition' => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->add_responsive_control(
		'body_pos_left',
		array(
			'label'      => esc_html__( 'Left', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => array(
				'size' => 50,
				'unit' => '%',
			),
			'size_units' => array(
				'px',
				'%',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 500,
				),
				'%'  => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-body' => 'left: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->end_controls_tab();
	$self->end_controls_tabs();

	$self->add_responsive_control(
		'min_height',
		array(
			'type'       => Controls_Manager::SLIDER,
			'label'      => esc_html__( 'Image Min Height', 'molla-core' ),
			'separator'  => 'after',
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 20,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-media img' => 'min-height: {{SIZE}}px; object-fit: cover',
			),
			'condition'  => array(
				'type'          => 'custom',
				'product_style' => 'full',
			),
		)
	);

	$self->add_control(
		'product_hover',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => esc_html__( 'Show Product Hover Image', 'molla-core' ),
			'default'   => 'yes',
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'product_vertical_animate',
		array(
			'type'      => Controls_Manager::SELECT,
			'label'     => esc_html__( 'Vertical Action Animation', 'molla-core' ),
			'default'   => 'fade-left',
			'options'   => array(
				''          => esc_html__( 'FadeIn', 'molla-core' ),
				'fade-left' => esc_html__( 'FadeInLeft', 'molla-core' ),
				'fade-up'   => esc_html__( 'FadeInUp', 'molla-core' ),
			),
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'visible_options',
		array(
			'label'       => esc_html__( 'Visible Items', 'molla-core' ),
			'type'        => Controls_Manager::SELECT2,
			'multiple'    => true,
			'default'     => array(
				'name',
				'cat',
				'price',
				'rating',
				'cart',
				'quickview',
				'wishlist',
				'deal',
			),
			'description' => esc_html__( 'Short description works only in full mode.', 'molla-core' ),
			'options'     => array(
				'name'      => esc_html__( 'Name', 'molla-core' ),
				'cat'       => esc_html__( 'Category', 'molla-core' ),
				'tag'       => esc_html__( 'Tag', 'molla-core' ),
				'price'     => esc_html__( 'Price', 'molla-core' ),
				'rating'    => esc_html__( 'Rating', 'molla-core' ),
				'cart'      => esc_html__( 'Add To Cart', 'molla-core' ),
				'quickview' => esc_html__( 'Quick View', 'molla-core' ),
				'wishlist'  => esc_html__( 'Wishlist', 'molla-core' ),
				'deal'      => esc_html__( 'Count Deal', 'molla-core' ),
				'attribute' => esc_html__( 'Attribute Support', 'molla-core' ),
				'desc'      => esc_html__( 'Short Description', 'molla-core' ),
				'quantity'  => esc_html__( 'Quantity', 'molla-core' ),
			),
			'condition'   => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'product_read_more',
		array(
			'type'        => Controls_Manager::SWITCHER,
			'label'       => esc_html__( 'Show "Read More" instead of "Add to cart"', 'molla-core' ),
			'description' => esc_html__( 'When "Add to cart" is disabled, "Read More" button will be displayed instead of it.' ),
			'default'     => 'yes',
			'condition'   => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'product_label_type',
		array(
			'type'      => Controls_Manager::SELECT,
			'label'     => esc_html__( 'Label Type', 'molla-core' ),
			'default'   => '',
			'options'   => array(
				''       => esc_html__( 'Square', 'molla-core' ),
				'circle' => esc_html__( 'Circle', 'molla-core' ),
			),
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'product_labels',
		array(
			'label'    => esc_html__( 'Labels', 'molla-core' ),
			'type'     => Controls_Manager::SELECT2,
			'multiple' => true,
			'default'  => array(
				'featured',
				'new',
				'onsale',
				'outstock',
			),
			'options'  => array(
				'featured' => esc_html__( 'Featured', 'molla-core' ),
				'new'      => esc_html__( 'New', 'molla-core' ),
				'onsale'   => esc_html__( 'Sale', 'molla-core' ),
				'outstock' => esc_html__( 'Out Stock', 'molla-core' ),
				'hurry'    => esc_html__( 'Hurry Up', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		'quickview_pos',
		array(
			'label'       => esc_html__( 'Quick View Position', 'molla-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'description' => esc_html__( 'Quick view button is placed by selected options in products.', 'molla-core' ),
			'options'     => array(
				''                  => esc_html__( 'Default', 'molla-core' ),
				'after-add-to-cart' => esc_html__( 'After Add To Cart', 'molla-core' ),
				'inner-thumbnail'   => esc_html__( 'Inner Thumbnail Vertical', 'molla-core' ),
				'center-thumbnail'  => esc_html__( 'Center of Thumbnail', 'molla-core' ),
			),
			'condition'   => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'wishlist_pos',
		array(
			'label'       => esc_html__( 'Wishlist Position', 'molla-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'description' => esc_html__( 'Wishlist button is placed by selected options in products.', 'molla-core' ),
			'options'     => array(
				''                    => esc_html__( 'Default', 'molla-core' ),
				'after-add-to-cart'   => esc_html__( 'After Add To Cart', 'molla-core' ),
				'after-product-title' => esc_html__( 'After Product Name', 'molla-core' ),
				'inner-thumbnail'     => esc_html__( 'Inner Thumbnail Vertical', 'molla-core' ),
			),
			'condition'   => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'wishlist_style',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => esc_html__( 'Wishlist Button Expandable', 'molla-core' ),
			'default'   => 'no',
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'out_stock_style',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => esc_html__( 'Show "Out-of-Stock" in body panel.', 'molla-core' ),
			'default'   => 'no',
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'product_icon_hide',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => esc_html__( 'Hide Icon', 'molla-core' ),
			'default'   => 'no',
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'product_label_hide',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => esc_html__( 'Hide Label', 'molla-core' ),
			'default'   => 'no',
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'disable_product_out',
		array(
			'type'      => Controls_Manager::SWITCHER,
			'label'     => esc_html__( 'Disable Out Of Stock Products', 'molla-core' ),
			'default'   => 'no',
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'action_icon_top',
		array(
			'type'        => Controls_Manager::SWITCHER,
			'settings'    => 'action_icon_top',
			'label'       => esc_html__( 'Icon Position Top', 'molla-core' ),
			'description' => esc_html__( 'In product action icon position is top of label.', 'molla-core' ),
			'condition'   => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_control(
		'divider_type',
		array(
			'label'       => esc_html__( 'Divider', 'molla-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'description' => esc_html__( 'For product buttons split.', 'molla-core' ),
			'options'     => array(
				''       => esc_html__( 'None', 'molla-core' ),
				'solid'  => esc_html__( 'Solid', 'molla-core' ),
				'dotted' => esc_html__( 'Dotted', 'molla-core' ),
			),
			'condition'   => array(
				'type' => 'custom',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Image_Size::get_type(),
		array(
			'name'      => 'thumbnail',
			'default'   => 'woocommerce_thumbnail',
			'separator' => 'none',
			'condition' => array(
				'type' => 'custom',
			),
		)
	);

	$self->end_controls_section();
}

function molla_el_products_style_controls( $self ) {
	$self->start_controls_section(
		'section_product_dim',
		array(
			'label' => esc_html__( 'Dimensions', 'molla-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

	$self->add_responsive_control(
		'heading_dimension',
		array(
			'label'      => esc_html__( 'Title Wrapper Spacing', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
			'condition'  => array(
				'title_pos' => array( '' ),
			),
		)
	);

	$self->add_responsive_control(
		'heading_dimension_pd',
		array(
			'label'      => esc_html__( 'Title Wrapper Padding', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .side' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
			'condition'  => array(
				'title_pos!' => array( '' ),
			),
		)
	);

	$self->add_responsive_control(
		'title_dimension',
		array(
			'label'      => esc_html__( 'Title Spacing', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'desc_dimension',
		array(
			'label'      => esc_html__( 'Description Spacing', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .heading-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'nav_dimension',
		array(
			'label'      => esc_html__( 'Filter Spacing', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .nav-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'products_spacing',
		array(
			'label'      => esc_html__( 'Products Spacing', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .products' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'more_btn_dimension',
		array(
			'label'      => esc_html__( 'Load More Button', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .more-container .btn-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->end_controls_section();

	$self->start_controls_section(
		'section_product_style',
		array(
			'label' => esc_html__( 'Typography', 'molla-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_heading_typography',
			'label'    => esc_html__( 'Title', 'molla-core' ),
			'selector' => '{{WRAPPER}} .heading-title',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_desc_typography',
			'label'    => esc_html__( 'Description', 'molla-core' ),
			'selector' => '{{WRAPPER}} .heading-desc',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_nav_typography',
			'label'    => esc_html__( 'Category Filter', 'molla-core' ),
			'selector' => '{{WRAPPER}} .nav-filter',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_title_typography',
			'label'    => esc_html__( 'Product Name', 'molla-core' ),
			'selector' => '{{WRAPPER}} .product-title',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_cat_typography',
			'label'    => esc_html__( 'Product Category', 'molla-core' ),
			'selector' => '{{WRAPPER}} .product-cat a',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_price_typography',
			'label'    => esc_html__( 'Product Price', 'molla-core' ),
			'selector' => '{{WRAPPER}} .price',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_new_price_typography',
			'label'    => esc_html__( 'Product New Price', 'molla-core' ),
			'selector' => '{{WRAPPER}} .price ins',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_old_price_typography',
			'label'    => esc_html__( 'Product Old Price', 'molla-core' ),
			'selector' => '{{WRAPPER}} .price del',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_button',
			'label'    => esc_html__( 'Product Buttons', 'molla-core' ),
			'selector' => '{{WRAPPER}} .product-action span',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'product_more_button',
			'label'    => esc_html__( 'View More Button', 'molla-core' ),
			'selector' => '{{WRAPPER}} .more-container .btn-more',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'      => 'product_sales_typography',
			'label'     => esc_html__( 'Total Sales', 'molla-core' ),
			'condition' => array(
				'total_sales!' => '',
			),
			'selector'  => '{{WRAPPER}} .product-sales',
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'      => 'product_sales_count_typography',
			'label'     => esc_html__( 'Total Sales Count', 'molla-core' ),
			'condition' => array(
				'total_sales!' => '',
			),
			'selector'  => '{{WRAPPER}} .product-sales mark',
		)
	);

	$self->end_controls_section();

	$self->start_controls_section(
		'section_product_color',
		array(
			'label' => esc_html__( 'Color', 'molla-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

	$self->start_controls_tabs( 'tabs_product_cat' );

	$self->start_controls_tab(
		'tab_product_cat_normal',
		array(
			'label' => esc_html__( 'Normal', 'molla-core' ),
		)
	);
	$self->add_control(
		'title_color',
		array(
			'label'     => esc_html__( 'Title', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .heading-title' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'desc_color',
		array(
			'label'     => esc_html__( 'Description', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .heading-desc' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_cat_color',
		array(
			'label'     => esc_html__( 'Product Category', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-cat a' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_title_color',
		array(
			'label'     => esc_html__( 'Product Name', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-title' => 'color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_product_cat_hover',
		array(
			'label' => esc_html__( 'Hover', 'molla-core' ),
		)
	);

	$self->add_control(
		'title_color_hover',
		array(
			'label'     => esc_html__( 'Title', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .heading-title:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_cat_color_hover',
		array(
			'label'     => esc_html__( 'Product Category', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-cat a:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_title_color_hover',
		array(
			'label'     => esc_html__( 'Product Name', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-title a:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->start_controls_tabs( 'tabs_bg_color' );

	$self->start_controls_tab(
		'tab_color_normal',
		array(
			'label' => esc_html__( 'Normal', 'molla-core' ),
		)
	);

	$self->add_control(
		'heading_btn_1',
		array(
			'label'     => esc_html__( 'Buttons Inner Content', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_btn_color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a, {{WRAPPER}} .btn-product' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_btn_bg_color',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a, {{WRAPPER}} .product-action .btn-product, {{WRAPPER}} .product-action.divided' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .product-action.divided a' => 'background-color: transparent;',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_btn_border',
			'selector' => '{{WRAPPER}} .product-action a, {{WRAPPER}} .btn-product',
		)
	);

	$self->add_control(
		'heading_btn_2',
		array(
			'label'     => esc_html__( 'Button Icons & Labels', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_btn_icon_color',
		array(
			'label'     => esc_html__( 'Icon Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:before, {{WRAPPER}} .btn-product:before' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_btn_label_color',
		array(
			'label'     => esc_html__( 'Label Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a span, {{WRAPPER}} .btn-product span' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_btn_label_border',
			'selector' => '{{WRAPPER}} .product-action a span, {{WRAPPER}} .btn-product span',
		)
	);

	$self->add_control(
		'heading_btn_3',
		array(
			'label'     => esc_html__( 'Vertical Buttons', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_vertical_btn_color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action-vertical a' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_vertical_btn_bg_color',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action-vertical a' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_vertical_btn_border',
			'selector' => '{{WRAPPER}} .product-action-vertical a',
		)
	);

	$self->add_control(
		'heading_btn_4',
		array(
			'label'     => esc_html__( 'View More Button', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_more_btn_color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .more-container .btn-more' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_more_btn_bg_color',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .more-container .btn-more' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_more_btn_border',
			'selector' => '{{WRAPPER}} .more-container .btn-more',
		)
	);

	$self->add_responsive_control(
		'more_btn_border_radius',
		array(
			'label'      => esc_html__( 'Border Radius', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .more-container .btn-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_control(
		'heading_btn_5',
		array(
			'label'     => esc_html__( 'Filtering', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .nav-filter a' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'bg_color',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .nav-filter a' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'nav_border',
			'selector' => '{{WRAPPER}} .nav-filter a',
		)
	);
	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_color_hover',
		array(
			'label' => esc_html__( 'Hover', 'molla-core' ),
		)
	);

	$self->add_control(
		'heading_btn_6',
		array(
			'label'     => esc_html__( 'Buttons Inner Content', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_btn_color_hover',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:hover, {{WRAPPER}} .btn-product:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_btn_bg_color_hover',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:hover, {{WRAPPER}} .btn-product:hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_btn_border_hover',
			'selector' => '{{WRAPPER}} .product-action a:hover, {{WRAPPER}} .btn-product:hover',
		)
	);

	$self->add_control(
		'heading_btn_7',
		array(
			'label'     => esc_html__( 'Button Icons & Labels', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_btn_icon_color_hover',
		array(
			'label'     => esc_html__( 'Icon Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:hover:before, {{WRAPPER}} .btn-product:hover:before' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_btn_label_color_hover',
		array(
			'label'     => esc_html__( 'Label Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:hover span, {{WRAPPER}} .btn-product:hover span' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_btn_label_border_hover',
			'selector' => '{{WRAPPER}} .product-action a:hover span, {{WRAPPER}} .btn-product:hover span',
		)
	);

	$self->add_control(
		'heading_btn_8',
		array(
			'label'     => esc_html__( 'Vertical Buttons', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_vertical_btn_color_hover',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action-vertical a:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_vertical_btn_bg_color_hover',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action-vertical a:hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_vertical_btn_border_hover',
			'selector' => '{{WRAPPER}} .product-action-vertical a:hover',
		)
	);

	$self->add_control(
		'heading_btn_9',
		array(
			'label'     => esc_html__( 'View More Button', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_more_btn_color_hover',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .more-container .btn-more:hover, {{WRAPPER}} .more-container .btn-more:focus' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_more_btn_bg_color_hover',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .more-container .btn-more:hover, {{WRAPPER}} .more-container .btn-more:focus' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_more_btn_border_hover',
			'selector' => '{{WRAPPER}} .more-container .btn-more:hover, {{WRAPPER}} .more-container .btn-more:focus',
		)
	);

	$self->add_control(
		'heading_btn_10',
		array(
			'label'     => esc_html__( 'Filtering', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'color_hover',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .nav-filter a:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'bg_color_hover',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .nav-filter a:hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'nav_border_hover',
			'selector' => '{{WRAPPER}} .nav-filter a:hover',
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_color_active',
		array(
			'label' => esc_html__( 'Active', 'molla-core' ),
		)
	);

	$self->add_control(
		'heading_btn_11',
		array(
			'label'     => esc_html__( 'Buttons Inner Content', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_btn_color_active',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:active, {{WRAPPER}} .btn-product:active' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_btn_bg_color_active',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:active, {{WRAPPER}} .btn-product:active' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_btn_border_active',
			'selector' => '{{WRAPPER}} .product-action a:active, {{WRAPPER}} .btn-product:active',
		)
	);

	$self->add_control(
		'heading_btn_12',
		array(
			'label'     => esc_html__( 'Button Icons & Labels', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_btn_icon_color_active',
		array(
			'label'     => esc_html__( 'Icon Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:active:before, {{WRAPPER}} .btn-product:active:before' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_btn_label_color_active',
		array(
			'label'     => esc_html__( 'Label Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action a:active span, {{WRAPPER}} .btn-product:active span' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_btn_label_border_active',
			'selector' => '{{WRAPPER}} .product-action a:active span, {{WRAPPER}} .btn-product:active span',
		)
	);

	$self->add_control(
		'heading_btn_13',
		array(
			'label'     => esc_html__( 'Vertical Buttons', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_vertical_btn_color_active',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action-vertical a:active' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_vertical_btn_bg_color_active',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action-vertical a:active' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_vertical_btn_border_active',
			'selector' => '{{WRAPPER}} .product-action-vertical a:active',
		)
	);

	$self->add_control(
		'heading_btn_14',
		array(
			'label'     => esc_html__( 'View More Button', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_more_btn_color_active',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .more-container .btn-more:active' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_more_btn_bg_color_active',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .more-container .btn-more:active' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_more_btn_border_active',
			'selector' => '{{WRAPPER}} .more-container .btn-more:active',
		)
	);

	$self->add_control(
		'heading_btn_15',
		array(
			'label'     => esc_html__( 'Filtering', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'color_active',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .nav-filter .active a' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'bg_color_active',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .nav-filter .active a' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'nav_border_active',
			'selector' => '{{WRAPPER}} .nav-filter .active a',
		)
	);
	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->add_control(
		'product_price_color',
		array(
			'label'     => esc_html__( 'Product Price', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'separator' => 'before',
			'selectors' => array(
				'{{WRAPPER}} .price' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_new_price_color',
		array(
			'label'     => esc_html__( 'Product New Price', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .price ins' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_old_price_color',
		array(
			'label'     => esc_html__( 'Product Old Price', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .price del' => 'color: {{VALUE}};',
			),
		)
	);

	$self->start_controls_tabs( 'tabs_product_label' );
	$self->start_controls_tab(
		'tab_product_top',
		array(
			'label' => esc_html__( 'Top', 'molla-core' ),
		)
	);

	$self->add_control(
		'product_top_color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .label-hot' => 'color: {{VALUE}};',
			),
		)
	);
	$self->add_control(
		'product_top_bg',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .label-hot' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_product_new',
		array(
			'label' => esc_html__( 'New', 'molla-core' ),
		)
	);

	$self->add_control(
		'product_new_color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .label-new' => 'color: {{VALUE}};',
			),
		)
	);
	$self->add_control(
		'product_new_bg',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .label-new' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_product_sale',
		array(
			'label' => esc_html__( 'Sale', 'molla-core' ),
		)
	);

	$self->add_control(
		'product_sale_color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .label-sale' => 'color: {{VALUE}};',
			),
		)
	);
	$self->add_control(
		'product_sale_bg',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .label-sale' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_product_out',
		array(
			'label' => esc_html__( 'Stock-Out', 'molla-core' ),
		)
	);

	$self->add_control(
		'product_out_color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .label-out' => 'color: {{VALUE}};',
			),
		)
	);
	$self->add_control(
		'product_out_bg',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .label-out' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();
	$self->end_controls_tabs();

	$self->add_control(
		'product_divider_color',
		array(
			'label'     => esc_html__( 'Divider Color', 'molla-core' ),
			'separator' => 'before',
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .product-action > * + *' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_sales_heading',
		array(
			'label'     => esc_html__( 'Total Sales', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'condition' => array(
				'total_sales!' => '',
			),
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_sales_label_color',
		array(
			'label'     => esc_html__( 'Total Sales', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'condition' => array(
				'total_sales!' => '',
			),
			'selectors' => array(
				'{{WRAPPER}} .product-sales' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_sales_count_color',
		array(
			'label'     => esc_html__( 'Total Sales Count', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'condition' => array(
				'total_sales!' => '',
			),
			'selectors' => array(
				'{{WRAPPER}} .product-sales mark' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_sales_background_color',
		array(
			'label'     => esc_html__( 'Percent Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'condition' => array(
				'total_sales!' => '',
			),
			'selectors' => array(
				'{{WRAPPER}} .product-sales-wrapper' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_sales_active_color',
		array(
			'label'     => esc_html__( 'Percent Active Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'condition' => array(
				'total_sales!' => '',
			),
			'selectors' => array(
				'{{WRAPPER}} .product-sales-percent' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_section();

	$self->start_controls_section(
		'product_box_shadow',
		array(
			'label' => esc_html__( 'Shadow Effect', 'molla-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

	$self->start_controls_tabs( 'tabs_product_box_shadow' );

	$self->start_controls_tab(
		'tab_box_shadow_normal',
		array(
			'label' => esc_html__( 'Normal', 'molla-core' ),
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => 'product_box_shadow',
			'selector' => '{{WRAPPER}} .product',
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_box_shadow_hover',
		array(
			'label' => esc_html__( 'Hover', 'molla-core' ),
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => 'product_box_shadow_hover',
			'selector' => '{{WRAPPER}} .product:hover',
		)
	);

	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->end_controls_section();

	molla_el_slider_style_controls( $self );
}

function molla_el_slider_style_controls( $self ) {
	$self->start_controls_section(
		'product_slider_style',
		array(
			'label' => esc_html__( 'Slider', 'molla-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

	$self->add_control(
		'heading_nav',
		array(
			'label' => esc_html__( 'Nav Options', 'molla-core' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$self->add_responsive_control(
		'slider_nav_font_size',
		array(
			'type'      => Controls_Manager::SLIDER,
			'label'     => esc_html__( 'Font Size', 'molla-core' ),
			'range'     => array(
				'px' => array(
					'step' => 1,
					'min'  => 20,
					'max'  => 100,
				),
			),
			'selectors' => array(
				'{{WRAPPER}} .owl-nav button' => 'font-size: {{SIZE}}px',
			),
		)
	);

	$self->add_responsive_control(
		'product_slider_nav_width',
		array(
			'type'       => Controls_Manager::SLIDER,
			'label'      => esc_html__( 'Width', 'molla-core' ),
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 20,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-nav button' => 'width: {{SIZE}}{{UNIT}}',
			),
		)
	);

	$self->add_responsive_control(
		'product_slider_nav_height',
		array(
			'type'       => Controls_Manager::SLIDER,
			'label'      => esc_html__( 'Height', 'molla-core' ),
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 20,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-nav button' => 'height: {{SIZE}}{{UNIT}}',
			),
		)
	);

	$self->add_responsive_control(
		'slider_nav_radius',
		array(
			'label'      => esc_html__( 'Border Radius', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'slider_nav_dim',
		array(
			'label'      => esc_html__( 'Position', 'molla-core' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-nav button'    => 'top: {{TOP}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}};',
				'{{WRAPPER}} .owl-nav .owl-prev' => 'left: {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .owl-nav .owl-next' => 'right: {{RIGHT}}{{UNIT}};',
			),
			'condition'  => array(
				'product_slider_nav_pos!' => 'owl-nav-top',
			),
		)
	);
	$self->start_controls_tabs( 'tabs_nav_position' );

	$self->start_controls_tab(
		'tab_nav_pos_top',
		array(
			'label'     => esc_html__( 'Top', 'molla-core' ),
			'condition' => array(
				'product_slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->add_responsive_control(
		'nav_pos_top',
		array(
			'label'      => esc_html__( 'Top', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => array(
				'size' => -2,
				'unit' => 'rem',
			),
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 500,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-nav' => 'top: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'product_slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_nav_pos_right',
		array(
			'label'     => esc_html__( 'Right', 'molla-core' ),
			'condition' => array(
				'product_slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->add_responsive_control(
		'nav_pos_right',
		array(
			'label'      => esc_html__( 'Right', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => array(
				'size' => -0.5,
				'unit' => 'rem',
			),
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 500,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-nav' => 'right: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'product_slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_nav_pos_bottom',
		array(
			'label'     => esc_html__( 'Bottom', 'molla-core' ),
			'condition' => array(
				'product_slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->add_responsive_control(
		'nav_pos_bottom',
		array(
			'label'      => esc_html__( 'Bottom', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 500,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-nav' => 'bottom: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'product_slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_nav_pos_left',
		array(
			'label'     => esc_html__( 'Left', 'molla-core' ),
			'condition' => array(
				'product_slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->add_responsive_control(
		'nav_pos_left',
		array(
			'label'      => esc_html__( 'Left', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array(
				'px',
				'%',
				'rem',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 500,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-nav' => 'left: {{SIZE}}{{UNIT}};',
			),
			'condition'  => array(
				'product_slider_nav_pos' => 'owl-nav-top',
			),
		)
	);

	$self->end_controls_tab();
	$self->end_controls_tabs();

	$self->start_controls_tabs( 'tabs_nav_bg_color' );

	$self->start_controls_tab(
		'tab_nav_bg_color_normal',
		array(
			'label' => esc_html__( 'Normal', 'molla-core' ),
		)
	);

	$self->add_control(
		'product_slider_nav_bg_color',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-nav button' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_slider_nav_color',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-nav button' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_slider_nav_border',
			'selector' => '{{WRAPPER}} .owl-nav button',
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => 'slider_nav_box_shadow',
			'selector' => '{{WRAPPER}} .owl-nav button',
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_nav_bg_color_hover',
		array(
			'label' => esc_html__( 'Hover', 'molla-core' ),
		)
	);

	$self->add_control(
		'product_slider_nav_hover_color',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'product_slider_nav_color_hover',
		array(
			'label'     => esc_html__( 'Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-nav button:not(.disabled):hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'product_slider_nav_border_hover',
			'selector' => '{{WRAPPER}} .owl-nav button:not(.disabled):hover',
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => 'slider_nav_box_shadow_hover',
			'selector' => '{{WRAPPER}} .owl-nav button:hover',
		)
	);

	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->add_control(
		'heading_dot',
		array(
			'label'     => esc_html__( 'Dot Options', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_responsive_control(
		'slider_dot_dim_vt',
		array(
			'label'      => esc_html__( 'Position Vertical', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array(
				'px',
				'%',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 300,
				),
				'%'  => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-dots' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
			),
			'condition'  => array(
				'product_slider_nav_pos!' => array( '' ),
			),
		)
	);

	$self->add_responsive_control(
		'slider_dot_dim_hz',
		array(
			'label'      => esc_html__( 'Position Horizontal', 'molla-core' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array(
				'px',
				'%',
			),
			'range'      => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 300,
				),
				'%'  => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 100,
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .owl-dots' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
			),
			'condition'  => array(
				'product_slider_nav_pos!' => array( '' ),
			),
		)
	);

	$self->add_responsive_control(
		'slider_dot_dim',
		array(
			'label'              => esc_html__( 'Position', 'molla-core' ),
			'type'               => Controls_Manager::DIMENSIONS,
			'allowed_dimensions' => 'vertical',
			'size_units'         => array(
				'px',
				'%',
			),
			'selectors'          => array(
				'{{WRAPPER}} .owl-dots' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
			),
			'condition'          => array(
				'product_slider_nav_pos' => array( '' ),
			),
		)
	);
	$self->start_controls_tabs( 'tabs_dot_color' );
	$self->start_controls_tab(
		'tab_dot_color',
		array(
			'label' => esc_html__( 'Normal', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_dot_bg_color',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'slider_dot_border_color',
		array(
			'label'     => esc_html__( 'Border Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-dots .owl-dot span' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_dot_color_hover',
		array(
			'label' => esc_html__( 'Hover', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_dot_bg_color_hover',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'slider_dot_border_color_hover',
		array(
			'label'     => esc_html__( 'Border Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_dot_color_active',
		array(
			'label' => esc_html__( 'Active', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_dot_bg_color_active',
		array(
			'label'     => esc_html__( 'Background Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'slider_dot_border_color_active',
		array(
			'label'     => esc_html__( 'Border Color', 'molla-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();
	$self->end_controls_tabs();

	$self->end_controls_section();

}

function molla_el_single_product_layout( $self ) {
	$self->start_controls_section(
		'section_products_layout',
		array(
			'label' => esc_html__( 'Products Layout', 'molla-core' ),
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

	$self->add_control(
		'cols_upper_desktop',
		array(
			'label'   => esc_html__( 'Columns Upper Desktop ( >= 1200px )', 'molla-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '2',
			'options' => array(
				''  => esc_html__( 'Default', 'molla-core' ),
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
			),
		)
	);

	$self->add_responsive_control(
		'columns',
		array(
			'type'    => Controls_Manager::SELECT,
			'label'   => esc_html__( 'Columns', 'molla-core' ),
			'default' => '2',
			'options' => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
			),
		)
	);

	$self->add_control(
		'cols_under_mobile',
		array(
			'label'   => esc_html__( 'Columns Under Mobile ( <= 575px )', 'molla-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '1',
			'options' => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
			),
		)
	);
	$self->add_control(
		'product_slider_heading',
		array(
			'label'     => esc_html__( 'Slider Options', 'molla-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$self->add_control(
		'product_slider_nav_pos',
		array(
			'label'   => esc_html__( 'Nav & Dot Position', 'molla-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				'owl-nav-inside' => esc_html__( 'Inner', 'molla-core' ),
				''               => esc_html__( 'Outer', 'molla-core' ),
				'owl-nav-top'    => esc_html__( 'Top', 'molla-core' ),
			),
		)
	);

	$self->add_control(
		'product_slider_nav_type',
		array(
			'label'   => esc_html__( 'Nav Type', 'molla-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''        => esc_html__( 'Type 1', 'molla-core' ),
				'full'    => esc_html__( 'Type 2', 'molla-core' ),
				'rounded' => esc_html__( 'Type 3', 'molla-core' ),
			),
		)
	);

	$self->add_responsive_control(
		'slider_nav',
		array(
			'type'  => Controls_Manager::SWITCHER,
			'label' => esc_html__( 'Show navigation?', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_nav_show',
		array(
			'type'    => Controls_Manager::SWITCHER,
			'label'   => esc_html__( 'Enable Navigation Auto Hide', 'molla-core' ),
			'default' => 'yes',
		)
	);

	$self->add_responsive_control(
		'slider_dots',
		array(
			'type'  => Controls_Manager::SWITCHER,
			'label' => esc_html__( 'Show slider dots?', 'molla-core' ),
		)
	);

	$self->add_control(
		'slider_loop',
		array(
			'label'   => esc_html__( 'Enable Loop', 'molla-core' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'no',
		)
	);

	$self->add_control(
		'slider_auto_play',
		array(
			'label'   => esc_html__( 'Enable Auto-Play', 'molla-core' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'no',
		)
	);

	$self->add_control(
		'slider_auto_play_time',
		array(
			'label'     => esc_html__( 'Autoplay Speed', 'molla-core' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 10000,
			'condition' => array(
				'slider_auto_play' => 'yes',
			),
		)
	);

	$self->add_control(
		'slider_center',
		array(
			'label'   => esc_html__( 'Enable Center Mode', 'molla-core' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'no',
		)
	);

	$self->add_control(
		'slider_item_height',
		array(
			'label'   => esc_html__( 'Enable Equal Height', 'molla-core' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'no',
		)
	);

	$self->end_controls_section();
}







