<?php

// ***** Disable plugin updates *****
remove_action('load-update-core.php', 'wp_update_plugins');
add_filter('pre_site_transient_update_plugins', '__return_null');

// ***** Remove Gutenberg block library *****
function remove_block_css() {
wp_dequeue_style( 'wp-block-library' ); // Wordpress core
wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
wp_dequeue_style( 'wc-block-style' ); // WooCommerce
wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
}
add_filter('use_block_editor_for_post_type', '__return_false', 10);
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );

//***** Allow svg post tags *****
function wp_kses_allowed_html_post_tags( $allowedposttags, $context ) {
    if ( $context === 'post' ) {
        $allowedposttags['svg']  = array(
			'fill' => true,
			'stroke' => true,
            'xmlns'   => true,
            'viewbox' => true
        );
        $allowedposttags['path'] = array(
            'd'    => true,
            'fill' => true,
			'stroke-linecap' => true,
			'stroke-linejoin' => true,
			'stroke-width' => true


        );
    }
    return $allowedposttags;
}
add_filter( 'wp_kses_allowed_html', 'wp_kses_allowed_html_post_tags', 10, 2 );

// ***** Woocommerce disable shipping calculation on cart page *****
function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );

// ***** Woocommerce remove product data tabs *****
function remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'remove_product_tabs', 98 );

// ***** Woocommerce add cost of goods custom field *****
function add_cost_of_goods() {
$args = array(
'label' => __( 'Costs of Goods (¥))', 'woocommerce' ),
'placeholder' => __( 'Costs of goods in ¥', 'woocommerce' ),
'id' => 'id_costs_of_goods',
'desc_tip' => true,
'description' => __( 'This field is for internal use only.', 'woocommerce' ),
);
	    
woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_inventory_product_data', 'add_cost_of_goods' );

// ***** Woocommerce save cost of goods custom field *****
function save_cost_of_goods( $post_id ) {
$custom_cost_of_goods = isset( $_POST[ 'id_costs_of_goods' ] ) ? sanitize_text_field( $_POST[ 'id_costs_of_goods' ] ) : '';
$product = wc_get_product( $post_id );
$product->update_meta_data( 'id_costs_of_goods', $custom_cost_of_goods );
$product->save();
}
add_action( 'woocommerce_process_product_meta', 'save_cost_of_goods' );

// ***** Woocommerce add vendor info custom field *****
function add_custom_vendor_info() {
$args = array(
'label' => __( 'Vendor Info', 'woocommerce' ),
'placeholder' => __( 'Enter vendor info here', 'woocommerce' ),
'id' => 'id_vendor_info',
'desc_tip' => true,
'description' => __( 'This field is for internal use only.', 'woocommerce' ),
);
woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_inventory_product_data', 'add_custom_vendor_info' );

// ***** Woocommerce save vendor info custom field *****
function save_custom_vendor_info( $post_id ) {
$custom_vendor_info = isset( $_POST[ 'id_vendor_info' ] ) ? sanitize_text_field( $_POST[ 'id_vendor_info' ] ) : '';
$product = wc_get_product( $post_id );
$product->update_meta_data( 'id_vendor_info', $custom_vendor_info );
$product->save();
}
add_action( 'woocommerce_process_product_meta', 'save_custom_vendor_info' );
 
// ***** Woocommerce add custom column into Product Page *****
function columns_into_product_list($defaults) {
    $defaults['id_costs_of_goods'] = 'Cost of Goods';
    return $defaults;
}
add_filter('manage_edit-product_columns', 'columns_into_product_list' );

// ***** Woocommerce add rows value into Product Page *****
function custom_column_into_product_list($column, $post_id ){
    switch ( $column ) {
    case 'id_costs_of_goods':
        echo get_post_meta( $post_id , 'id_costs_of_goods' , true );
    break;
    }
}
add_action( 'manage_product_posts_custom_column' , 'custom_column_into_product_list', 10, 2 );

// ***** Infinite Scrolling *****
function filter_product_post_class( $classes, $class, $product_id ){
if( in_the_loop() )
$classes[] = 'mainproduct';
return $classes;
}
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'post_class', 'filter_product_post_class', 10, 3 );


// ***** Signifyd API *****
function signifyd_api() {
?>
<script
defer
type="text/javascript"
id="sig-api"
data-order-session-id="edb7tuzg7vffgvwsry43fsikz85aqu3yb5a3esfrjmu26nuh7m"
src="https://cdn-scripts.signifyd.com/api/script-tag.js"></script>
<?php
}
add_action('wp_head', 'signifyd_api');