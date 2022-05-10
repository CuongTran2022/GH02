<?php

defined( 'ABSPATH' ) || die;

/**
 * Molla Single Product Widget Render
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Products Selector
			'ids'               => '',
			'category'          => '',
			'status'            => '',
			'count'             => array( 'size' => 10 ),
			'orderby'           => '',
			'order'             => 'ASC',
			'order_from'        => '',
			'order_from_date'   => '',
			'order_to'          => '',
			'order_to_date'     => '',
			'hide_out_date'     => '',

			// Single Product
			'sp_title_tag'      => 'h2',
			'sp_gallery_type'   => '',
			'sp_show_info'      => '',
			'sp_show_thumbnail' => '',
			'page_builder'      => 'elementor',
			'thumbnail_size'    => 'woocommerce_single',

			//Layout Options
			// 'layout_mode'             => '',
			// 'spacing'                 => '',
			// 'cols_upper_desktop'      => '',
			// //'columns'         => 1,
			// 'columns_tablet'  => '',
			// 'columns_mobile'  => '',
			// 'cols_under_mobile'       => '',
			// 'product_slider_nav_pos'  => '',
			// 'product_slider_nav_type' => '',
			// 'slider_nav'              => 'no',
			// 'slider_nav_show'         => 'yes',
			// 'slider_nav_tablet'       => 'no',
			// 'slider_nav_mobile'       => 'no',
			// 'slider_dot'              => 'no',
			// 'slider_dot_tablet'       => 'no',
			// 'slider_dot_mobile'       => 'no',
			// 'slider_loop'             => 'no',
			// 'slider_auto_play'        => 'no',
			// 'slider_auto_play_time'   => 10000,
			// 'slider_center'           => 'no',
		),
		$atts
	)
);


$product_ids = $ids;
include_once MOLLA_CORE_DIR . '/elementor/partials/single-product.php';
$col_cnt = array(
	'xl'  => isset( $atts['cols_upper_desktop'] ) ? (int) $atts['cols_upper_desktop'] : 0,
	'lg'  => isset( $atts['columns'] ) ? (int) $atts['columns'] : 0,
	'md'  => boolval( $atts['columns_tablet'] ) ? (int) $atts['columns_tablet'] : 1,
	'sm'  => boolval( $atts['columns_mobile'] ) ? (int) $atts['columns_mobile'] : 1,
	'xs'  => isset( $atts['cols_under_mobile'] ) ? (int) $atts['cols_under_mobile'] : 0,
	'min' => isset( $atts['cols_under_mobile'] ) ? (int) $atts['cols_under_mobile'] : 0,
);

// Parse product IDs or slugs
if ( ! empty( $product_ids ) && is_string( $product_ids ) ) {

	$product_ids = explode( ',', str_replace( ' ', '', esc_attr( $product_ids ) ) );

	if ( defined( 'MOLLA_VERSION' ) ) {
		for ( $i = 0; isset( $product_ids[ $i ] );  ++ $i ) {
			if ( ! is_numeric( $product_ids[ $i ] ) ) {
				$product_ids[ $i ] = molla_get_post_id_by_name( 'product', $product_ids[ $i ] );
			}
		}
	}
}

if ( $product_ids && 1 == count( $product_ids ) ) {
	global $post, $product;
	$original_post    = $post;
	$original_product = $product;
	$post             = get_post( $product_ids[0] );
	$product          = wc_get_product( $post );

	molla_set_single_product_widget( $atts );   //Set woocommerce actions
	wc_get_template_part( 'content', 'single-product' );
	molla_unset_single_product_widget( $atts );
	$post    = $original_post;
	$product = $original_product;

} else {
	// Several Single Products ///////////////////////////////////////////////////////////////////

	// Get Count
	if ( ! is_array( $count ) ) {
		$count = json_decode( $count, true );
	} else {
		$count = (int) $count['size'];
	}

	if ( $category && ! is_array( $category ) ) {
		$categories = explode( ',', $category );
	}

	$query_args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'posts_per_page'      => $count,
		'fields'              => 'ids',
		'orderby'             => wc_clean( wp_unslash( $orderby ) ),
		'meta_query'          => WC()->query->get_meta_query(),
		'tax_query'           => array(),
	);

	// product status
	if ( 'featured' == $status ) {
		$query_args['tax_query'][] = array(
			'taxonomy'         => 'product_visibility',
			'terms'            => 'featured',
			'field'            => 'name',
			'operator'         => 'IN',
			'include_children' => false,
		);
	} elseif ( 'on_sale' == $status ) {
		$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
	} elseif ( 'related' == $status || 'upsell' == $status ) {
		global $product;
		if ( ! empty( $product ) ) {
			if ( 'related' == $status ) {
				$product_ids = wc_get_related_products( $product->get_id(), $count, $product->get_upsell_ids() );
			} else {
				$product_ids = $product->get_upsell_ids();
			}
		}
	}

	// If not empty linked products for single product
	if ( ! ( ( 'related' == $status || 'upsell' == $status ) && is_array( $product_ids ) && count( $product_ids ) == 0 ) ) {
		if ( $product_ids ) {
			if ( is_string( $product_ids ) ) {
				// custom IDs
				$product_ids = explode( ',', str_replace( ' ', '', esc_attr( $product_ids ) ) );
				if ( defined( 'MOLLA_VERSION' ) ) {
					for ( $i = 0; isset( $product_ids[ $i ] );  ++ $i ) {
						if ( ! is_numeric( $product_ids[ $i ] ) ) {
							$product_ids[ $i ] = molla_get_post_id_by_name( 'product', $product_ids[ $i ] );
						}
					}
				}
			}
			if ( is_array( $product_ids ) ) {
				$query_args['post__in'] = $product_ids;
				$query_args['orderby']  = 'post__in';
			}
		} else {
			// custom ordering
			$query_args['order']   = esc_attr( $order );
			$query_args['orderby'] = esc_attr( $orderby );

			if ( $order_from ) {
				if ( 'custom' == $order_from && $order_from_date ) {
					set_query_var( 'order_from', esc_attr( $order_from_date ) );
				} elseif ( 'custom' !== $order_from ) {
					set_query_var( 'order_from', esc_attr( $order_from ) );
				}
			}
			if ( $order_to ) {
				if ( 'custom' == $order_to && $order_to_date ) {
					set_query_var( 'order_to', esc_attr( $order_to_date ) );
				} elseif ( 'custom' !== $order_to ) {
					set_query_var( 'order_to', esc_attr( $order_to ) );
				}
			}
			set_query_var( 'hide_out_date', $hide_out_date );
		}

		if ( is_array( $category ) && count( $category ) ) {
			// custom categories
			$query_args['tax_query'] = array_merge(
				WC()->query->get_tax_query(),
				array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => esc_attr( implode( ',', $category ) ),
					),
				)
			);
		}
	}

	$query = new WP_Query( $query_args );

	if ( $query->have_posts() && defined( 'WC_ABSPATH' ) ) {
		molla_set_single_product_widget( $atts );

		global $post, $product;
		$original_post    = $post;
		$original_product = $product;
		$product_ids      = $query->posts;
		update_meta_cache( 'post', $product_ids );
		update_object_term_cache( $product_ids, 'product' );

		if ( $query->post_count > 1 ) {
			?>
			<div class="single-products
			<?php
			echo esc_attr( molla_get_slider_classes( $atts ) );
			echo esc_attr( molla_get_column_class( $col_cnt ) );
			?>
			"
				data-toggle="owl"
				data-owl-options="<?php echo esc_attr( json_encode( molla_get_slider_attrs( $atts, $col_cnt ) ) ); ?>">			
			<?php
		}

		foreach ( $product_ids as $product_id ) {
			$post = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $post );
			wc_get_template_part( 'content', 'single-product' );
		}
		if ( $query->post_count > 1 ) {

			?>
			</div>
			<?php
		}

		molla_unset_single_product_widget( $atts );
		$post    = $original_post;
		$product = $original_product;
		wp_reset_postdata();
	}
}
