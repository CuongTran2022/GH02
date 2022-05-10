<?php
/**
 * @dgwt_wcas_premium_only
 */
namespace DgoraWcas\Integrations\Plugins\B2BKing;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Integration with B2BKing
 *
 * Plugin URL: https://webwizards.dev/
 * Author: WebWizards
 */
class B2BKing {
	public function init() {
		if ( ! dgoraAsfwFs()->is_premium() ) {
			return;
		}

		if ( ! defined( 'B2BKING_DIR' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'storeInSessionIncludedProducts' ), 20 );
	}

	/**
	 * Store visible product ids in session
	 */
	public function storeInSessionIncludedProducts() {
		if ( ! session_id() ) {
			session_start();
		}
		if ( intval( get_option( 'b2bking_all_products_visible_all_users_setting', 1 ) ) !== 1 ) {
			if ( get_option( 'b2bking_plugin_status_setting', 'disabled' ) !== 'disabled' ) {
				$visible_ids = get_transient( 'b2bking_user_' . get_current_user_id() . '_ajax_visibility' );
				if ( ! empty( $visible_ids ) ) {
					$_SESSION['dgwt-wcas-b2bking-visible-products'] = $visible_ids;
				}
			} else {
				$_SESSION['dgwt-wcas-b2bking-visible-products'] = - 1;
			}
		} else {
			$_SESSION['dgwt-wcas-b2bking-visible-products'] = - 1;
		}
	}
}
