<?php

if ( isset( $_POST['ajax_loadmore'] ) && $_POST['ajax_loadmore'] ) {
	return;
}

do_action( 'page_container_after', 'bottom' );

$footer_tooltip = molla_option( 'footer_tooltip_label' );
if ( ! $footer_tooltip ) {
	$footer_tooltip = esc_html__( 'Footer', 'molla' );
}

?>
			</div>
			<?php get_template_part( 'template-parts/partials/scroll', 'top' ); ?>
		</div>
		<?php
		$footer_show = array();
		global $post, $molla_settings;
		if ( $post ) {
			$post_id     = molla_get_page_layout( $post );
			$footer_show = get_post_meta( $post_id, 'footer_show' );
		}
		if ( is_array( $footer_show ) && ( ! $footer_show || 'show' == $footer_show[0] ) ) :
			if ( 'footer' == get_post_type() ) {
				echo '<footer class="custom-footer full-inner footer-' . get_the_ID() . '" id="footer">';
				the_content();
				echo '</footer>';
			} elseif ( isset( $molla_settings['footer']['builder'] ) && function_exists( 'molla_print_custom_post' ) ) {
				echo '<footer class="custom-footer full-inner footer-' . $molla_settings['footer']['builder'] . '" id="footer">';
				molla_print_custom_post( 'footer', $molla_settings['footer']['builder'] );
				echo '</footer>';
			} else {
				$footer_class  = 'footer';
				$footer_class .= molla_option( 'footer_top_divider_active' ) || molla_option( 'footer_main_divider_active' ) || molla_option( 'footer_bottom_divider_active' ) ? ' divider-active' : '';
				$footer_class  = apply_filters( 'molla_footer_classes', $footer_class );
				?>
			<footer class="<?php echo esc_attr( $footer_class ); ?>" data-section-tooltip="<?php echo esc_html( $footer_tooltip ); ?>">
				<?php
				$footer_block_name = molla_option( 'footer_block_name' );
				if ( $footer_block_name ) {
					if ( function_exists( 'molla_print_custom_post' ) ) {
						molla_print_custom_post( 'block', $footer_block_name );
					} else {
						echo '<strong>Plugin not installed.</strong>';
					}
				} else {

					$elems = array(
						'top',
						'main',
						'bottom',
					);

					$footer_width = $molla_settings['footer']['width'];

					foreach ( $elems as $elem ) {
						molla_get_template_part( 'template-parts/footer/footer', $elem, array( 'width' => $footer_width ) );
					}
				}
				?>
			</footer>
				<?php
			}
		endif;
		?>

	</div>
	<?php
	get_template_part( 'template-parts/header/header', 'mobile' );

	do_action( 'molla_body_before_end' );

	wp_footer();
	?>

<!--Icon chat -->
<div class="live-button">
    <div class="live-button-content" style="display: none;">
<!--        	<a href="tel:091" class="call-icon" rel="nofollow">
          <i class="fa fa-phone" aria-hidden="true"></i>
        </a>
        <a href="sms:091" class="sms">
          <i class="fa fa-commenting-o" aria-hidden="true"></i>
        </a> -->
        <a href="https://www.facebook.com" class="messenger">
          <i class="fab fa-facebook-f" aria-hidden="true"></i>
        </a>
        <a href="http://zalo.me/091" class="zalo">
          <i>Z</i>
        </a>
    </div>
       
    <a class="content-support">
      <i class="far fa-comment" aria-hidden="true"></i>
      <div class="animated live-circle"></div>
      <div class="animated live-circle-fill"></div>
    </a>
</div>

<style>
    .live-button{
      	display: inline-grid;
        position: fixed;
        bottom: 15px;
        left: 45px;
        min-width: 45px;
        text-align: center;
        z-index: 99999;
    }
    .live-button-content{
		display: inline-grid;   
    }
    .live-button a {
		cursor: pointer;
		position: relative;
      	width: 40px;
        height: 40px;
        background: #43a1f3;
        border-radius: 100%;
	}
	.live-button .live-button-content a {
		margin-bottom: 16px
	}
    .live-button i{
        color: #fff;
        font-size: 20px;
        text-align: center;
        line-height: 1.9;
        position: relative;
        z-index: 999;
    }
    .live-circle {
        animation-iteration-count: infinite;
        animation-duration: 1s;
        animation-fill-mode: both;
        animation-name: zoomIn;
        width: 50px;
        height: 50px;
        top: -5px;
        right: -4px;
        position: absolute;
        background-color: transparent;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        border-radius: 100%;
        border: 2px solid rgba(30, 30, 30, 0.4);
        opacity: .1;
        border-color: #0089B9;
        opacity: .5;
    }
    .live-circle-fill {
		animation-iteration-count: infinite;
	 	animation-duration: 1s;
		animation-fill-mode: both;
		animation-name: pulse;
        width: 60px;
        height: 60px;
        top: -10px;
        right: -10px;
        position: absolute;
        -webkit-transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -ms-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
        transition: all 0.2s ease-in-out;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        border-radius: 100%;
        border: 2px solid transparent;
        background-color: rgba(0, 175, 242, 0.5);
        opacity: .75;
    }
    @-webkit-keyframes "headerAnimation" {
        0% { margin-top: -70px; }
        100% { margin-top: 0; }
    }
    @keyframes "headerAnimation" {
        0% { margin-top: -70px; }
        100% { margin-top: 0; }
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    $('.content-support').click(function(event) {
      $('.live-button-content').slideToggle();
    });
});
</script>

</body>
</html>
