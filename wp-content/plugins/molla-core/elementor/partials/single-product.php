<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'molla_set_single_product_image_size' ) ) {
	function molla_set_single_product_image_size( $thumbnail_size ) {
		global $molla_spw_settings;
		$thumbnail_size = $molla_spw_settings['thumbnail_size'];
		return $thumbnail_size;
	}
}

if ( ! function_exists( 'molla_single_product_widget_get_title_tag' ) ) {
	function molla_single_product_widget_get_title_tag() {
		global $molla_spw_settings;
		return isset( $molla_spw_settings['sp_title_tag'] ) ? $molla_spw_settings['sp_title_tag'] : 'h2';
	}
}

if ( ! function_exists( 'molla_set_single_product_layout' ) ) {
	function molla_set_single_product_layout() {
		global $molla_spw_settings;
		if ( 'horizontal' == $molla_spw_settings['sp_gallery_type'] ) {
			return 'extended';
		} else {
			return 'default';}
	}
}

if ( ! function_exists( 'molla_set_single_product_widget' ) ) {
	function molla_set_single_product_widget( $atts ) {
		global $molla_spw_settings;
		$molla_spw_settings = $atts;

		// Add woocommerce default filters for compatibility with single product
		if ( molla_is_elementor_preview() &&
			! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ) ) { // Add only once

			if ( ! has_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 ) ) {
				add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			}

			if ( ! has_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 ) ) {
				add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			}

			// Add woocommerce actions for compatibility in elementor editor.
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			}
		}

		add_filter( 'molla_is_single_product_widget_title', '__return_true' );
		add_filter( 'molla_is_single_product_widget', 'molla_set_single_product_layout' );
		add_filter( 'molla_single_product_title_tag', 'molla_single_product_widget_get_title_tag' );
		add_filter( 'woocommerce_gallery_image_size', 'molla_set_single_product_image_size' );
		add_filter( 'molla_wc_thumbnail_image_size', 'molla_set_single_product_image_size' );

		if ( '' == $atts['sp_show_thumbnail'] ) {
			add_filter( 'molla_is_hide_single_product_thumbnail', '__return_true' );
		}

		if ( ! empty( $atts['sp_show_info'] ) && is_array( $atts['sp_show_info'] ) ) {
			$sp_show_info = $atts['sp_show_info'];
			if ( ! in_array( 'title', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! in_array( 'meta', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			}
			if ( ! in_array( 'price', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			}
			if ( ! in_array( 'rating', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! in_array( 'excerpt', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! in_array( 'countdown', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'molla_woocommerce_single_product_deal', 25 );
			}
			if ( ! in_array( 'addtocart_form', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
		}

		if ( class_exists( 'Molla_Skeleton' ) ) {
			Molla_Skeleton::prevent_skeleton();
		}
	}
}

if ( ! function_exists( 'molla_unset_single_product_widget' ) ) {
	function molla_unset_single_product_widget( $atts ) {
		global $molla_spw_settings;
		unset( $molla_spw_settings );

		remove_filter( 'molla_is_single_product_widget_title', '__return_true' );
		remove_filter( 'molla_is_single_product_widget', 'molla_set_single_product_layout' );
		remove_filter( 'woocommerce_gallery_image_size', 'molla_set_single_product_image_size' );
		remove_filter( 'molla_wc_thumbnail_image_size', 'molla_set_single_product_image_size' );

		if ( '' == $atts['sp_show_thumbnail'] ) {
			remove_filter( 'molla_is_hide_single_product_thumbnail', '__return_true' );
		}

		if ( ! empty( $atts['sp_show_info'] ) && is_array( $atts['sp_show_info'] ) ) {
			$sp_show_info = $atts['sp_show_info'];
			if ( ! in_array( 'title', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! in_array( 'meta', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			}
			if ( ! in_array( 'price', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			}
			if ( ! in_array( 'rating', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! in_array( 'excerpt', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! in_array( 'countdown', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'molla_woocommerce_single_product_deal', 25 );
			}
			if ( ! in_array( 'addtocart_form', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
		}

		if ( class_exists( 'Molla_Skeleton' ) && ! molla_is_elementor_preview() ) {
			Molla_Skeleton::stop_prevent_skeleton();
		}

	}
}





