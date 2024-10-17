/* Start Add "Menu" on Appearance */
add_theme_support( 'menus' );
/* End Add "Menu" on Appearance */

/* Start Buy Now Button after Add To Cart Button */
function sbw_wc_add_buy_now_button_single()
{
    global $product;
    printf( '<button id="sbw_wc-adding-button" type="submit" name="sbw-wc-buy-now" value="%d" class="single_add_to_cart_button buy_now_button button alt wp-element-button">%s</button>', $product->get_ID(), esc_html__('Buy Now', 'sbw-wc' ) );
}
function sbw_wc_handle_buy_now()
{
    if ( !isset( $_REQUEST['sbw-wc-buy-now'] ) ) {
        return false;
    }
    WC()->cart->empty_cart();
    $product_id = absint( $_REQUEST['sbw-wc-buy-now'] );
    $quantity = absint( $_REQUEST['quantity'] );

    if ( isset( $_REQUEST['variation_id'] ) ) {
        $variation_id = absint( $_REQUEST['variation_id'] );
        WC()->cart->add_to_cart( $product_id, 1, $variation_id );
    }else{
        WC()->cart->add_to_cart( $product_id, $quantity );
    }
    wp_safe_redirect( wc_get_checkout_url() );
    exit;
}
add_action( 'woocommerce_after_add_to_cart_button', 'sbw_wc_add_buy_now_button_single' );
add_action( 'wp_loaded', 'sbw_wc_handle_buy_now' );
/* End Buy Now Button after Add To Cart Button */

/* Start Add Link on Image Cover Blocks */
add_filter('render_block_core/shortcode', function(string $block_content): string {
    return do_shortcode($block_content);
}); 
add_action( 'init', function(){
    register_block_style( 'core/cover', array(
        'name'         => 'full-link',
        'label'        => 'Link',
        'inline_style' => '.wp-block-cover.is-style-full-link a:after {
            display:block;
            position:absolute;
            left:0;
            top:0;
            width:100%;
            height:100%;
            content:"";
        }'
    ));
});
/* End Add Link on Image Cover Blocks */
