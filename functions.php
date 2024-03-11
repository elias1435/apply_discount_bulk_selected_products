<?php


add_action( 'woocommerce_cart_calculate_fees', 'apply_custom_discount_based_on_quantity', 10, 1 );
function apply_custom_discount_based_on_quantity( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    // product ids
    $product_ids = array( 1864, 1863, 1861, 1627 );
    // minimum qunatity
    $required_quantity = 4;
    // discount percentage
    $discount_percentage = 10;
    $product_count = 0;

    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        if ( in_array( $cart_item['product_id'], $product_ids ) ) {
            $product_count += $cart_item['quantity'];
        }
    }

    if ( $product_count >= $required_quantity ) {
        // Calculate discount before tax
        $subtotal_ex_tax = $cart->get_subtotal( false, 'edit' );
        $discount = $subtotal_ex_tax * ( $discount_percentage / 100 );

        // Apply discount
        $cart->add_fee( __('Discount', 'woocommerce'), -$discount );
    }
}
