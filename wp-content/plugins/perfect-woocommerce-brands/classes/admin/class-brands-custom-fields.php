<?php

namespace Perfect_Woocommerce_Brands\Admin;

defined('ABSPATH') or die('No script kiddies please!');

class Brands_Custom_Fields
{

  function __construct()
  {
    add_action('pwb-brand_add_form_fields', array($this, 'add_brands_metafields_form'));
    add_action('pwb-brand_edit_form_fields', array($this, 'add_brands_metafields_form_edit'));
    add_action('edit_pwb-brand', array($this, 'add_brands_metafields_save'));
    add_action('create_pwb-brand', array($this, 'add_brands_metafields_save'));
  }

  public function add_brands_metafields_form()
  {
    $provinces = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_provinces();
    ob_start();
?>
    <!-- ROTICA custom address -->
    <div class="form-field pwb_brand_contc form-required">
      <label for="pwd_brand_province"><?php _e('Tỉnh/Thành phố', 'perfect-woocommerce-brands'); ?></label>
      <select id="pwd_brand_province" name="pwd_brand_province" style="width: 100%" aria-required="true">
        <option value="" selected disabled>Chọn Tỉnh/Thành phố</option>
        <?php 
            foreach ($provinces as $province) {
              echo '<option '.(($province->id == $_GET['pv'])?'selected="true"':"").'  value="'.$province->id.'">'.$province->text.'</option>';
            }
        ?>
      </select>
    </div>
    <input type="text" hidden name="pwd_brand_province_name" id="pwd_brand_province_name" value="" >

    <div class="form-field pwb_brand_cont">
      <label for="pwd_brand_district">Quận/huyện</label>
      <select id="pwd_brand_district" name="pwd_brand_district" style="width: 100%" aria-required="true" required>
        <option value="" selected disabled>Chọn Quận/Huyện</option>
      </select>
    </div>
    <input type="text" hidden name="pwd_brand_district_name" id="pwd_brand_district_name" value="">

    <div class="form-field pwb_brand_cont">
      <label for="pwd_brand_ward">Phường/Xã</label>
      <select id="pwd_brand_ward" name="pwd_brand_ward" style="width: 100%" aria-required="true" required>
        <option value="" selected disabled>Chọn Phường/Xã</option>
      </select>
    </div>
    <input type="text" hidden name="pwd_brand_ward_name" id="pwd_brand_ward_name" value="">

    <div class="form-field pwb_brand_cont form-required">
      <label for="pwd_brand_address">Địa chỉ cụ thể</label>
      <input type="text" name="pwd_brand_address" id="pwd_brand_address" value="" aria-required="true">
      <p>Địa chỉ của trường học(Hiển thị ở Danh sách trường học)</p>
    </div>

    <!--/ ROTICA custom address -->

    <div class="form-field pwb_brand_cont">
      <label for="pwb_brand_desc"><?php _e('Description'); ?></label>
      <textarea id="pwb_brand_description_field" name="pwb_brand_description_field" rows="5" cols="40"></textarea>
      <p id="brand-description-help-text"><?php _e('Brand description for the archive pages. You can include some html markup and shortcodes.', 'perfect-woocommerce-brands'); ?></p>
    </div>

    <div class="form-field pwb_brand_cont">
      <label for="pwb_brand_image"><?php _e('Brand logo', 'perfect-woocommerce-brands'); ?></label>
      <input type="text" name="pwb_brand_image" id="pwb_brand_image" value="">
      <a href="#" id="pwb_brand_image_select" class="button"><?php esc_html_e('Select image', 'perfect-woocommerce-brands'); ?></a>
    </div>

    <div class="form-field pwb_brand_cont">
      <label for="pwb_brand_banner"><?php _e('Brand banner', 'perfect-woocommerce-brands'); ?></label>
      <input type="text" name="pwb_brand_banner" id="pwb_brand_banner" value="">
      <a href="#" id="pwb_brand_banner_select" class="button"><?php esc_html_e('Select image', 'perfect-woocommerce-brands'); ?></a>
      <p><?php _e('This image will be shown on brand page', 'perfect-woocommerce-brands'); ?></p>
    </div>

    <div class="form-field pwb_brand_cont">
      <label for="pwb_brand_banner_link"><?php _e('Brand banner link', 'perfect-woocommerce-brands'); ?></label>
      <input type="text" name="pwb_brand_banner_link" id="pwb_brand_banner_link" value="">
      <p><?php _e('This link should be relative to site url. Example: product/product-name', 'perfect-woocommerce-brands'); ?></p>
    </div>

    <?php wp_nonce_field(basename(__FILE__), 'pwb_nonce'); ?>

  <?php
    echo ob_get_clean();
  }

  public function add_brands_metafields_form_edit($term)
  {
    $term_value_image = get_term_meta($term->term_id, 'pwb_brand_image', true);
    $term_value_banner = get_term_meta($term->term_id, 'pwb_brand_banner', true);
    $term_value_banner_link = get_term_meta($term->term_id, 'pwb_brand_banner_link', true);

    $pwd_brand_province = get_term_meta($term->term_id, 'pwd_brand_province', true);
    $pwd_brand_province_name = get_term_meta($term->term_id, 'pwd_brand_province_name', true);
    $pwd_brand_district = get_term_meta($term->term_id, 'pwd_brand_district', true);
    $pwd_brand_district_name = get_term_meta($term->term_id, 'pwd_brand_district_name', true);
    $pwd_brand_ward = get_term_meta($term->term_id, 'pwd_brand_ward', true);
    $pwd_brand_ward_name = get_term_meta($term->term_id, 'pwd_brand_ward_name', true);
    $pwd_brand_address = get_term_meta($term->term_id, 'pwd_brand_address', true);
    $provinces = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_provinces();
    if (isset($pwd_brand_province)){
      $districts = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_districts($pwd_brand_province);
    }
    if (isset($pwd_brand_district)){
      $wards = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_wards($pwd_brand_district);
    }

    ob_start();
    $image_size_selected = get_option('wc_pwb_admin_tab_brand_logo_size', 'thumbnail');

  ?>
    <?php if (!empty($pwd_brand_province_name)) : ?>
      <input type="text" id="isEdit" value="1" hidden>
      </input>
    <?php endif; ?>
    <table class="form-table pwb_brand_cont">
      <tr class="form-field">
        <th>
          <label for="pwb_brand_desc"><?php _e('Description'); ?></label>
        </th>
        <td>
          <?php wp_editor(html_entity_decode($term->description), 'pwb_brand_description_field', array('editor_height' => 120)); ?>
          <p id="brand-description-help-text"><?php _e('Brand description for the archive pages. You can include some html markup and shortcodes.', 'perfect-woocommerce-brands'); ?></p>
        </td>
      </tr>
      <!-- ROTICA address -->
      <tr class="form-field">
        <th>
          <label for="pwd_brand_province">Tỉnh/Thành phố</label>
        </th>
        <td>
          <select id="pwd_brand_province" name="pwd_brand_province" style="width: 100%">
            <option value="" selected disabled>Chọn Tỉnh/Thành phố</option>
            <?php 
                foreach ($provinces as $province) {
                  echo '<option '.(($province->id == $pwd_brand_province)?'selected="true"':"").'  value="'.$province->id.'">'.$province->text.'</option>';
                }
            ?>
          </select>
          <input type="text" hidden name="pwd_brand_province_name" id="pwd_brand_province_name" value="<?php echo esc_html($pwd_brand_province_name); ?>">

        </td>
      </tr>

      <tr class="form-field">
        <th>
          <label for="pwd_brand_district">Quận/Huyện</label>
        </th>
        <td>
          <select id="pwd_brand_district" name="pwd_brand_district" style="width: 100%">
            <option value="" selected disabled>Chọn Quận/Huyện</option>
            <?php 
                foreach ($districts as $district) {
                  echo '<option '.(($district->id == $pwd_brand_district)?'selected="true"':"").'  value="'.$district->id.'">'.$district->text.'</option>';
                }
            ?>
          </select>
          <input type="text" hidden name="pwd_brand_district_name" id="pwd_brand_district_name" value="<?php echo esc_html($pwd_brand_district_name); ?>">
        </td>
      </tr>

      <tr class="form-field">
        <th>
          <label for="pwd_brand_ward">Phường/Xã</label>
        </th>
        <td>
        <select id="pwd_brand_ward" name="pwd_brand_ward" style="width: 100%" default>
          <option value="" selected disabled>Chọn Phường/Xã</option>
          <?php 
              foreach ($wards as $ward) {
                echo '<option '.(($ward->id == $pwd_brand_ward)?'selected="true"':"").'  value="'.$ward->id.'">'.$ward->text.'</option>';
              }
          ?>
          </select>
          <input type="text" hidden name="pwd_brand_ward_name" id="pwd_brand_ward_name" value="<?php echo esc_html($pwd_brand_ward_name); ?>">

        </td>
      </tr>

      <tr class="form-field form-required">
        <th>
          <label for="pwd_brand_address">Tỉnh/Thành phố</label>
        </th>
        <td>
          <input type="text" name="pwd_brand_address" id="pwd_brand_address" value="<?php echo esc_html($pwd_brand_address); ?>" aria-required="true">
        </td>
      </tr>

      <!-- / ROTICA address -->
      <tr class="form-field">
        <th>
          <label for="pwb_brand_image"><?php _e('Brand logo', 'perfect-woocommerce-brands'); ?></label>
        </th>
        <td>
          <input type="text" name="pwb_brand_image" id="pwb_brand_image" value="<?php echo esc_attr($term_value_image); ?>">
          <a href="#" id="pwb_brand_image_select" class="button"><?php esc_html_e('Select image', 'perfect-woocommerce-brands'); ?></a>

          <?php $current_image = wp_get_attachment_image($term_value_image, $image_size_selected, false); ?>
          <?php if (!empty($current_image)) : ?>
            <div class="pwb_brand_image_selected">
              <span>
                <?php echo wp_kses_post($current_image); ?>
                <a href="#" class="pwb_brand_image_selected_remove">X</a>
              </span>
            </div>
          <?php endif; ?>

        </td>
      </tr>
      <tr class="form-field">
        <th>
          <label for="pwb_brand_banner"><?php _e('Brand banner', 'perfect-woocommerce-brands'); ?></label>
        </th>
        <td>
          <input type="text" name="pwb_brand_banner" id="pwb_brand_banner" value="<?php echo esc_html($term_value_banner); ?>">
          <a href="#" id="pwb_brand_banner_select" class="button"><?php esc_html_e('Select image', 'perfect-woocommerce-brands'); ?></a>

          <?php $current_image = wp_get_attachment_image($term_value_banner, 'full', false); ?>
          <?php if (!empty($current_image)) : ?>
            <div class="pwb_brand_image_selected">
              <span>
                <?php echo wp_kses_post($current_image); ?>
                <a href="#" class="pwb_brand_image_selected_remove">X</a>
              </span>
            </div>
          <?php endif; ?>

        </td>
      </tr>
      <tr class="form-field">
        <th>
          <label for="pwb_brand_banner_link"><?php _e('Brand banner link', 'perfect-woocommerce-brands'); ?></label>
        </th>
        <td>
          <input type="text" name="pwb_brand_banner_link" id="pwb_brand_banner_link" value="<?php echo esc_html($term_value_banner_link); ?>">
          <p class="description"><?php _e('This link should be relative to site url. Example: product/product-name', 'perfect-woocommerce-brands'); ?></p>
          <div id="pwb_brand_banner_link_result"><?php echo wp_get_attachment_image($term_value_banner_link, array('90', '90'), false); ?></div>
        </td>
      </tr>
    </table>

    <?php wp_nonce_field(basename(__FILE__), 'pwb_nonce'); ?>

<?php
    echo ob_get_clean();
  }

  public function add_brands_metafields_save($term_id)
  {

    if (!isset($_POST['pwb_nonce']) || !wp_verify_nonce($_POST['pwb_nonce'], basename(__FILE__)))
      return;

    /* ·············· Brand image ·············· */
    $old_img = get_term_meta($term_id, 'pwb_brand_image', true);
    $new_img = isset($_POST['pwb_brand_image']) ? $_POST['pwb_brand_image'] : '';

    if ($old_img && '' === $new_img)
      delete_term_meta($term_id, 'pwb_brand_image');

    else if ($old_img !== $new_img)
      update_term_meta($term_id, 'pwb_brand_image', $new_img);
    /* ·············· /Brand image ·············· */

    /* ·············· Brand banner ·············· */
    $old_img = get_term_meta($term_id, 'pwb_brand_banner', true);
    $new_img = isset($_POST['pwb_brand_banner']) ? $_POST['pwb_brand_banner'] : '';

    if ($old_img && '' === $new_img)
      delete_term_meta($term_id, 'pwb_brand_banner');

    else if ($old_img !== $new_img)
      update_term_meta($term_id, 'pwb_brand_banner', $new_img);
    /* ·············· /Brand banner ·············· */

    /* ·············· Brand banner link ·············· */
    $old_img = get_term_meta($term_id, 'pwb_brand_banner_link', true);
    $new_img = isset($_POST['pwb_brand_banner_link']) ? $_POST['pwb_brand_banner_link'] : '';

    if ($old_img && '' === $new_img)
      delete_term_meta($term_id, 'pwb_brand_banner_link');

    else if ($old_img !== $new_img)
      update_term_meta($term_id, 'pwb_brand_banner_link', $new_img);
    /* ·············· /Brand banner link ·············· */

    /* ·············· Brand desc ·············· */
    if (isset($_POST['pwb_brand_description_field'])) {
      $allowed_tags = apply_filters(
        'pwb_description_allowed_tags',
        '<p><span><a><ul><ol><li><h1><h2><h3><h4><h5><h6><pre><strong><em><blockquote><del><ins><img><code><hr>'
      );
      $desc = strip_tags(wp_unslash($_POST['pwb_brand_description_field']), $allowed_tags);
      global $wpdb;
      $wpdb->update($wpdb->term_taxonomy, ['description' => $desc], ['term_id' => $term_id]);
    }
    /* ·············· /Brand desc ·············· */

    // ROTICA - province
    $old_province = get_term_meta($term_id, 'pwd_brand_province', true);
    $new_province = isset($_POST['pwd_brand_province']) ? $_POST['pwd_brand_province'] : '';
    $new_province_name = isset($_POST['pwd_brand_province_name']) ? $_POST['pwd_brand_province_name'] : '';

    if ($old_province && '' === $new_province){
      delete_term_meta($term_id, 'pwd_brand_province');
      delete_term_meta($term_id, 'pwd_brand_province_name');
    }else if ($old_province !== $new_province){
      update_term_meta($term_id, 'pwd_brand_province', $new_province);
      update_term_meta($term_id, 'pwd_brand_province_name', $new_province_name);
    }
      

    // ROTICA - district
    $old_district = get_term_meta($term_id, 'pwd_brand_district', true);
    $new_district = isset($_POST['pwd_brand_district']) ? $_POST['pwd_brand_district'] : '';
    $new_district_name = isset($_POST['pwd_brand_district_name']) ? $_POST['pwd_brand_district_name'] : '';
    if ($old_district && '' === $new_district){
      delete_term_meta($term_id, 'pwd_brand_district');
      delete_term_meta($term_id, 'pwd_brand_district_name');
    }
    else if ($old_district !== $new_district){
      update_term_meta($term_id, 'pwd_brand_district', $new_district);
      update_term_meta($term_id, 'pwd_brand_district_name', $new_district_name);
    }

    // ROTICA - ward
    $old_ward = get_term_meta($term_id, 'pwd_brand_ward', true);
    $new_ward = isset($_POST['pwd_brand_ward']) ? $_POST['pwd_brand_ward'] : '';
    $new_ward_name = isset($_POST['pwd_brand_ward_name']) ? $_POST['pwd_brand_ward_name'] : '';

    if ($old_ward && '' === $new_ward){
      delete_term_meta($term_id, 'pwd_brand_ward');
      delete_term_meta($term_id, 'pwd_brand_ward_name');
    }
    else if ($old_ward !== $new_ward){
      update_term_meta($term_id, 'pwd_brand_ward', $new_ward);
      update_term_meta($term_id, 'pwd_brand_ward_name', $new_ward_name);
    }

    // ROTICA - address
    $old_address = get_term_meta($term_id, 'pwd_brand_address', true);
    $new_address = isset($_POST['pwd_brand_address']) ? $_POST['pwd_brand_address'] : '';

    if ($old_address && '' === $new_address)
      delete_term_meta($term_id, 'pwd_brand_address');

    else if ($old_address !== $new_address)
      update_term_meta($term_id, 'pwd_brand_address', $new_address);
  }
}
