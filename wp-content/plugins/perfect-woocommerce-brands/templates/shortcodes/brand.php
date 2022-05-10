<?php

/**
 * The template for displaying the "pwb-brand" shortcode
 * @version 1.0.0
 */

defined('ABSPATH') or die('No script kiddies please!');
?>

<?php if (!empty($brands)) : ?>

  <div class="pwb-brand-shortcode">

    <?php foreach ($brands as $brand) : ?>

      <a href="<?php echo esc_url($brand->term_link); ?>" title="<?php _e('View brand', 'perfect-woocommerce-brands'); ?>">

        <?php if (!$as_link && !empty($brand->image)) : ?>

          <?php echo wp_kses_post($brand->image); ?>

        <?php else : ?>

          <?php echo esc_html($brand->name); ?>

        <?php endif; ?>

      </a>

    <?php endforeach; ?>

  </div>

<?php endif; ?>