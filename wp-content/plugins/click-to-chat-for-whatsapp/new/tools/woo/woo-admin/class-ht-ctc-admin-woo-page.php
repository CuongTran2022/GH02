<?php
/**
 * WooCommerce settings page - admin 
 * 
 * @package ctc
 * @subpackage admin
 * @since 3.3.3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Admin_Woo_Page' ) ) :

class HT_CTC_Admin_Woo_Page {

    public function __construct() {
        $this->start();
	}

    function start() {
        add_action('admin_menu', array($this, 'menu') );
        add_action('admin_init', array($this, 'settings') );
    }

    public function menu() {

        // dashicons-format-chat  /  dashicons-whatsapp
        $icon = 'dashicons-whatsapp';
        if( version_compare( get_bloginfo('version'), '5.6', '<') )  {
            $icon = 'dashicons-format-chat';
        }

        add_submenu_page(
            'click-to-chat',
            'WooCommerce page',
            'WooCommerce',
            'manage_options',
            'click-to-chat-woocommerce',
            array( $this, 'settings_page' )
        );
    }

    public function settings_page() {

        if ( ! current_user_can('manage_options') ) {
            return;
        }

        ?>

        <div class="wrap">

            <?php settings_errors(); ?>

            <!-- full row -->
            <div class="row">

                <div class="col s12 m12 xl7 options">
                    <form action="options.php" method="post" class="">
                        <?php settings_fields( 'ht_ctc_woo_page_settings_fields' ); ?>
                        <?php do_settings_sections( 'ht_ctc_woo_page_settings_sections_do' ) ?>
                        <?php submit_button() ?>
                    </form>
                </div>

                <!-- sidebar content -->
                <div class="col s12 m12 l7 xl4 ht-ctc-admin-sidebar ht-ctc-admin-woo-sidebar sticky-sidebar">
                    <?php // include_once HT_CTC_PLUGIN_DIR .'new/admin/admin_commons/admin-sidebar-content.php'; ?>
                </div>
                
            </div>

            <!-- new row - After settings page  -->
            <div class="row">
            </div>

        </div>

        <?php

    }


    public function settings() {

        // WooCommerce chat feautes
        register_setting( 'ht_ctc_woo_page_settings_fields', 'ht_ctc_woo_options' , array( $this, 'options_sanitize' ) );
    
        add_settings_section( 'ht_ctc_woo_page_settings_sections_add', '', array( $this, 'chat_settings_section_cb' ), 'ht_ctc_woo_page_settings_sections_do' );

        add_settings_field( 'woo_single_product', __( 'Single Product Pages', 'click-to-chat-for-whatsapp'), array( $this, 'woo_single_product_cb' ), 'ht_ctc_woo_page_settings_sections_do', 'ht_ctc_woo_page_settings_sections_add' );

    }


    public function chat_settings_section_cb() {
        ?>
        <h1 id="woo_settings">WooCommerce WhatsApp Chat Settings </h1>
        <br>
        <?php
        do_action('ht_ctc_ah_admin' );
    }

     

    /**
     * single product pages
     * 
     * @var [woo_is_single] - floating style for single product pages
     */
    function woo_single_product_cb() {
        $options = get_option('ht_ctc_woo_options');
        $dbrow = 'ht_ctc_woo_options';

        $chat = get_option('ht_ctc_chat_options');

        // pre filled
        $woo_pre_filled = ( isset( $options['woo_pre_filled']) ) ? esc_attr( $options['woo_pre_filled'] ) : '';
        
        $pf_placeholder = "Hello {site} \nLike to buy {product}, {url}";
        
        // call to action
        $woo_call_to_action = ( isset( $options['woo_call_to_action']) ) ? esc_attr( $options['woo_call_to_action'] ) : '';
        
        $ctc_placeholder = 'Buy {product}';

        ?>
        
        <ul class="collapsible ht_ctc_woo_1">
        <li class="">
        <div class="collapsible-header"><?php _e( 'WooCommerce', 'click-to-chat-for-whatsapp' ); ?> - <?php _e( 'Single Product Pages', 'click-to-chat-for-whatsapp' ); ?></div>
        <div class="collapsible-body">

        <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/woocommerce-single-product-pages/"><?php _e( 'WooCommerce Single Product pages', 'click-to-chat-for-whatsapp' ); ?></a></p>
        <!-- <p class="description">Leave blank to get values from main settings</p> -->
        <br>

        <!-- prefilled message -->
        <div class="row">
            <div class="input-field col s12">
                <textarea name="ht_ctc_woo_options[woo_pre_filled]" id="woo_pre_filled" class="materialize-textarea input-margin" style="min-height: 84px;" placeholder="<?= $pf_placeholder ?>"><?= $woo_pre_filled ?></textarea>
                <label for="woo_pre_filled"><?php _e( 'Pre-filled message', 'click-to-chat-for-whatsapp' ); ?></label>
                <!-- <span class="helper-text" data-error="wrong" data-success="right"><?php _e( 'Leave blank to get value from main settings', 'click-to-chat-for-whatsapp' ); ?></span> -->
                <!-- <p class="description">Pre-filled message for WooCommerce Single Product pages</p> -->
            </div>
        </div>


        <!-- Call to Action -->
        <div class="row">
            <div class="input-field col s12">
                <input name="ht_ctc_woo_options[woo_call_to_action]" value="<?= $woo_call_to_action ?>" id="woo_call_to_action" type="text" class="input-margin" placeholder="<?= $ctc_placeholder ?>">
                <label for="woo_call_to_action"><?php _e( 'Call to Action', 'click-to-chat-for-whatsapp' ); ?></label>
                <!-- <span class="helper-text" data-error="wrong" data-success="right"><?php _e( 'Leave blank to get value from main settings', 'click-to-chat-for-whatsapp' ); ?></span> -->
                <!-- <p class="description">Call-to-Action for WooCommerce Single Product pages</p> -->
            </div>
        </div>

        <!-- docs - prefilled, call to action .. -->
        <p class="description">Variables: {product}, {price}, {regular_price}, {sku}, {site}, {url}, {title} </p>
        <!-- <p class="description">Change Values for WooCommerce Single Product pages - <a target="_blank" href="https://holithemes.com/plugins/click-to-chat/woocommerce-single-product-pages/"><?php _e( 'more info', 'click-to-chat-for-whatsapp' ); ?></a></p> -->
        <p class="description">Leave blank to get value from main settings</p>

        <?php
        // // do_action('ht_ctc_ah_admin_woo_after_single_product_pages' );
        
        // // Add styles at woo page position
        // $woo_position = ( isset( $options['woo_position']) ) ? esc_attr( $options['woo_position'] ) : '';
        // $woo_style = ( isset( $options['woo_style']) ) ? esc_attr( $options['woo_style'] ) : '';

        // $woo_places = [
        //     'woocommerce_before_single_product_summary' => 'Before Single Product',
        //     'woocommerce_after_add_to_cart_button' => 'After Cart',
        //     'woocommerce_before_main_content' => 'Before Main Content',
        //     'woocommerce_after_single_product' => 'After single product',
        // ];
        ?>


        <!-- Add button/icon -->
        <!-- <div class="row">
            <div class="col s6" style="padding-top: 14px;">
                <p><?php _e( 'Add Button/Icon', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?php echo $dbrow ?>[woo_position]" class="woo_position">
                    <option value="select" <?php echo $woo_position == "select" ? 'SELECTED' : ''; ?> ><?php _e( 'Select', 'click-to-chat-for-whatsapp' ); ?></option>
                    <?php
                    foreach ($woo_places as $key => $value) {
                        ?>
                        <option value="<?= $key ?>" <?php echo $woo_position == $key ? 'SELECTED' : ''; ?> ><?php _e( $value, 'click-to-chat-for-whatsapp' ); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div> -->

        <!-- style -->
        <!-- <div class="row">
            <div class="col s6" style="padding-top: 14px;">
                <p><?php _e( 'Select Style', 'click-to-chat-for-whatsapp' ); ?></p>
            </div>
            <div class="input-field col s6">
                <select name="<?= $dbrow; ?>[woo_style]" class="chat_select_style select_style_desktop">
                    <option value="1" <?= $woo_style == 1 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-1', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="2" <?= $woo_style == 2 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-2', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="3" <?= $woo_style == 3 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-3', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="3_1" <?= $woo_style == '3_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-3 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="4" <?= $woo_style == 4 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-4', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="5" <?= $woo_style == 5 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-5', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="7" <?= $woo_style == 7 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-7', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="7_1" <?= $woo_style == '7_1' ? 'SELECTED' : ''; ?> >&emsp;<?php _e( 'Style-7 Extend', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="8" <?= $woo_style == 8 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-8', 'click-to-chat-for-whatsapp' ); ?></option>
                    <option value="99" <?= $woo_style == 99 ? 'SELECTED' : ''; ?> ><?php _e( 'Style-99 (Add your own image / GIF)', 'click-to-chat-for-whatsapp' ); ?></option>
                </select>
                <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/list-of-styles/?utm_source=ctc&utm_medium=admin&utm_campaign=woo"><?php _e( 'List of Styles', 'click-to-chat-for-whatsapp' ); ?></a> &emsp; | &emsp; <span><a target="_blank" href="<?= admin_url( 'admin.php?page=click-to-chat-customize-styles' ); ?>">Customize the styles</a></span> </p>
            </div>
        </div> -->

        </div>
        </div>
        </li>
        <ul>


        <?php
        // todo: add content - how to change settings at cart, checkout page
    }




    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function options_sanitize( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }

        $new_input = array();

        foreach ($input as $key => $value) {
            if( isset( $input[$key] ) ) {

                if ( 'woo_pre_filled' == $key ) {
                    $new_input[$key] = sanitize_textarea_field( $input[$key] );
                } else {
                    $new_input[$key] = sanitize_text_field( $input[$key] );
                }
            }
        }

        // l10n
        foreach ($input as $key => $value) {
            if ( 'woo_pre_filled' == $key || 'woo_call_to_action' == $key ) {
                do_action( 'wpml_register_single_string', 'Click to Chat for WhatsApp', $key, $input[$key] );
            }
        }

        do_action('ht_ctc_ah_admin_after_sanitize' );

        return $new_input;
    }


}

new HT_CTC_Admin_Woo_Page();

endif; // END class_exists check