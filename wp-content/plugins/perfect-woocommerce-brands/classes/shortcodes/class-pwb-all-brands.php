<?php

namespace Perfect_Woocommerce_Brands\Shortcodes;

defined('ABSPATH') or die('No script kiddies please!');

class PWB_All_Brands_Shortcode
{

  public static function all_brands_shortcode($atts)
  {

    $atts = shortcode_atts(array(
      'per_page'       => "10",
      'image_size'     => "thumbnail",
      'hide_empty'     => false,
      'order_by'       => 'name',
      'order'          => 'ASC',
      'title_position' => 'before'
    ), $atts, 'pwb-all-brands');

    $hide_empty = ($atts['hide_empty'] != 'true') ? false : true;

    ob_start();

    $brands = array();
    $districts = array();
    $ward = array();
    if ($atts['order_by'] == 'rand') {
      $brands = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_brands($hide_empty);
      shuffle($brands);
    } else {

      $addressSearch = (object) [];
      
      if (isset($_GET['pv']))
        $addressSearch->pwd_brand_province = $_GET['pv'];
        $districts = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_districts($_GET['pv']);
      if (isset($_GET['dt'])){
        $addressSearch->pwd_brand_district = $_GET['dt'];
        $wards = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_wards($_GET['dt']);
      }
      if (isset($_GET['wa'])){
        $addressSearch->pwd_brand_ward = $_GET['wa']; 
      }
      
      $brands = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_brands($hide_empty, $atts['order_by'], $atts['order'], false, false, false, $addressSearch);
      $provinces = \Perfect_Woocommerce_Brands\Perfect_Woocommerce_Brands::get_provinces();
    }

    //remove residual empty brands
    foreach ($brands as $key => $brand) {

      $count = self::count_visible_products($brand->term_id);

      if (!$count && $hide_empty) {
        unset($brands[$key]);
      } else {
        $brands[$key]->count_pwb = $count;
      }
    }
    $search_text_default = '';
    if (isset($_GET['pwb-search'])) {
      $search_text_default = $_GET['pwb-search'];
    }
?>
<main id="main" class="site-main" role="main">
  <div class="container left-sidebar">
    <div class="row sidebar-wrapper sticky-sidebar-wrapper">
      <aside class="col-lg-3" >
        <div class="sidebar shop-sidebar sticky-sidebar shop-sidebar sidebar-toggle"
          style="border-bottom: 0px none rgb(119, 119, 119);">
          <div class="sidebar-content">
            <form id="search_brand_form" action="<?php echo get_the_permalink(); ?>" method="get" style="min-height: 550px">
              <div class="yith-woocommerce-ajax-product-filter yith-woo-ajax-reset-navigation yith-woo-ajax-navigation woocommerce widget_layered_nav">
                <label style="font-size: 24px">Tìm kiếm:</label>
                <div class="yith-wcan"><a class="yith-wcan-reset-navigation" href="<?php echo get_the_permalink() ?>">Xóa
                    tất cả</a></div>
                </div>
              <div>
                <div style="display: grid" class="mb-5">
                  <label>Tìm theo tên trường học:</label>
                  <input type="search" name="pwb-search" id="pwb-search" value="<?php echo $search_text_default; ?>" size="40"
                    class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email"
                    placeholder="Nhập tên trường học...">
                </div>
              </div>

              <div class="widget woocommerce widget_product_categories p-0 pt-4">
                <h3 class="widget-title">Địa chỉ trường</h3>
                <ul class="product-categories" style="display: none;">
                  <li>
                    <div style="display: grid;" id="pv_wrap">
                      <label>Tỉnh/Thành phố</label>
                      <select id="pwd_brand_province" style="width: 100%" name="pv">
                        <option value="" selected disabled>Chọn Tỉnh/Thành phố</option>
                        <?php 
                            foreach ($provinces as $province) {
                              echo '<option '.(($province->id == $_GET['pv'])?'selected="true"':"").'  value="'.$province->id.'">'.$province->text.'</option>';
                            }
                        ?>
                      </select>
                    </div>
                  </li>
                  <li>
                    <div style="display: grid;" id="dt_wrap">
                      <label>Quận/Huyện</label>
                      <select id="pwd_brand_district" style="width: 100%" name="dt">
                        <option value="" selected disabled>Chọn Quận/Huyện</option>
                        <?php 
                            foreach ($districts as $district) {
                              echo '<option '.(($district->id == $_GET['dt'])?'selected="true"':"").'  value="'.$district->id.'">'.$district->text.'</option>';
                            }
                        ?>
                      </select>
                    </div>
                  </li>
                  <li>
                    <div style="display: grid;" id="wa_wrap">
                      <label>Phường/Xã</label>
                      <select id="pwd_brand_ward" style="width: 100%" name="wa">
                        <option value="" selected disabled>Chọn Phường/Xã</option>
                        <?php 
                            foreach ($wards as $ward) {
                              echo '<option '.(($ward->id == $_GET['wa'])?'selected="true"':"").'  value="'.$ward->id.'">'.$ward->text.'</option>';
                            }
                        ?>
                      </select>
                    </div>
                  </li>
                </ul>
              </div>
              
              <div>
                <button type="submit" class="wpcf7-form-control btn-primary btn" style="min-width: 125px">Tìm kiếm</button>
              </div>
            </form>
          </div>

        </div>
      </aside>

      <div class="col-lg-9">
        <div class="toolbox">
          <div class="woocommerce-notices-wrapper"></div>

          <div class="toolbox-right">
            <div class="toolbox-info">
              <p class="woocommerce-result-count">
                Tìm thấy <span class="from"><?php echo esc_html(count($brands)) ?></span> trường học.</p>
            </div>
          </div>
          
        </div>
        <div class="pwb-all-brands">
          <?php static::pagination($brands, $atts['per_page'], $atts['image_size'], $atts['title_position']); ?>
        </div>
        <!-- <div class="products products-dark-loop columns-4 row c-lg-4 c-md-3 c-xs-2 sp-20"
          data-props="{&quot;loop&quot;:0,&quot;columns&quot;:&quot;4&quot;,&quot;name&quot;:&quot;&quot;,&quot;is_shortcode&quot;:false,&quot;is_paginated&quot;:true,&quot;is_search&quot;:false,&quot;is_filtered&quot;:false,&quot;total&quot;:6,&quot;total_pages&quot;:1,&quot;per_page&quot;:8,&quot;current_page&quot;:1,&quot;cols_tablet&quot;:3,&quot;cols_mobile&quot;:2,&quot;cols_under_mobile&quot;:2,&quot;visible&quot;:{&quot;name&quot;:true,&quot;cat&quot;:false,&quot;tag&quot;:false,&quot;price&quot;:true,&quot;rating&quot;:false,&quot;cart&quot;:true,&quot;wishlist&quot;:false,&quot;quickview&quot;:true,&quot;deal&quot;:false,&quot;attribute&quot;:false,&quot;desc&quot;:false,&quot;quantity&quot;:false},&quot;quickview_pos&quot;:&quot;inner-thumbnail&quot;,&quot;wishlist_pos&quot;:-1,&quot;footer_action&quot;:0,&quot;body_action&quot;:0,&quot;footer_out_body&quot;:0,&quot;product_style&quot;:&quot;dark&quot;,&quot;product_align&quot;:&quot;center&quot;,&quot;out_stock_style&quot;:null,&quot;product_vertical_animate&quot;:&quot;fade-left&quot;,&quot;product_icon_hide&quot;:null,&quot;product_label_hide&quot;:null,&quot;disable_product_out&quot;:null,&quot;action_icon_top&quot;:null,&quot;divider_type&quot;:null,&quot;product_label_type&quot;:&quot;circle&quot;,&quot;x_pos&quot;:4,&quot;y_pos&quot;:95,&quot;t_y_pos&quot;:&quot;center&quot;,&quot;wishlist_style&quot;:null,&quot;extra_atts&quot;:{&quot;pwb-brand&quot;:&quot;thpt-marie-curie&quot;}}">
        </div> -->
      </div>
    </div>
    <a href="#" class="sidebar-toggler active"><i class="fa fa-chevron-right"></i></a>
    <div class="sidebar-overlay"></div>
  </div>
</main>

    <?php

    return ob_get_clean();
  }

  /**
   *  WP_Term->count property don´t care about hidden products
   *  Counts the products in a specific brand
   */
  public static function count_visible_products($brand_id)
  {

    $args = array(
      'posts_per_page' => -1,
      'post_type'      => 'product',
      'tax_query'      => array(
        array(
          'taxonomy'  => 'pwb-brand',
          'field'     => 'term_id',
          'terms'     => $brand_id
        ),
        array(
          'taxonomy' => 'product_visibility',
          'field'    => 'name',
          'terms'    => 'exclude-from-catalog',
          'operator' => 'NOT IN',
        )
      )
    );
    $wc_query = new \WP_Query($args);

    return $wc_query->found_posts;
  }

  public static function pagination($display_array, $show_per_page, $image_size, $title_position)
  {
    $page = 1;

    $search_text = '';

    $new_array = $display_array;

    if (isset($_GET['pwb-page']) && filter_var($_GET['pwb-page'], FILTER_VALIDATE_INT) == true) {
      $page = $_GET['pwb-page'];
    }

    if (isset($_GET['pwb-search']) && $_GET['pwb-search'] != "") {
      $search_text = $_GET['pwb-search'];

      $new_array = array_filter($display_array, function($obj) use ($search_text){
        if (isset($obj->name)) {
          $brand_name = $obj->name;
          $include_search = strpos(strtolower($brand_name), strtolower($search_text));
          if (false !== $include_search) return true;
        }
        return false;
      });
    }

    $page = $page < 1 ? 1 : $page;

    // start position in the $display_array
    // +1 is to account for total values.
    $start = ($page - 1) * ($show_per_page);
    $offset = $show_per_page;

    $outArray = array_slice($new_array, $start, $offset);

    //pagination links
    $total_elements = count($display_array);
    $pages = ((int)$total_elements / (int)$show_per_page);
    $pages = ceil($pages);
    if ($pages >= 1 && $page <= $pages) {

    ?>
      <div class="pwb-brands-cols-outer">
        <?php
        foreach ($outArray as $brand) {

          $brand_id   = $brand->term_id;
          $brand_name = $brand->name;
          $brand_link = get_term_link($brand_id);

          $attachment_id = get_term_meta($brand_id, 'pwb_brand_image', 1);
          $attachment_html = $brand_name;
          if ($attachment_id != '') {
            $attachment_html = wp_get_attachment_image($attachment_id, $image_size);
          }

        ?>
          <div class="pwb-brands-col3">

            <?php if ($title_position != 'none' && $title_position != 'after') : ?>
              <p>
                <a href="<?php echo esc_url($brand_link); ?>">
                  <?php echo esc_html($brand_name); ?>
                </a>
                <small>(<?php echo esc_html($brand->count_pwb); ?>)</small>
              </p>
            <?php endif; ?>

            <div class="pwd-brands-icon-wrap">
              <a href="<?php echo esc_url($brand_link); ?>" title="<?php echo esc_html($brand_name); ?>">
                <?php echo wp_kses_post($attachment_html); ?>
              </a>
            </div>

            <?php if ($title_position != 'none' && $title_position == 'after') : ?>
              <p>
                <a href="<?php echo esc_html($brand_link); ?>">
                  <?php echo wp_kses_post($brand_name); ?>
                </a>
                <small>(<?php echo esc_html($brand->count_pwb); ?>)</small>
              </p>
            <?php endif; ?>

          </div>
        <?php
        }
        ?>
      </div>
<?php
    } else {
      echo esc_html__('Không tìm thấy', 'perfect-woocommerce-brands');
    }
  }
}
