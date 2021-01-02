<?php

/** 
 * Add Custom EAN Meta Field
 * Save meta data to DB
 */

// Simple products
// Display EAN field

add_action( 'woocommerce_product_options_inventory_product_data', 'applause_simple_product_ean_field', 10, 1 );

function applause_simple_product_ean_field() {

    global $woocommerce, $post;

    $product = new WC_Product( get_the_ID() );

    echo '<div id="ean_attr" class="options_group">';

    woocommerce_wp_text_input( 
        array(  
            'id'            => '_ean',
            'label'         => __( 'EAN', 'applause' ), 
            // 'placeholder'   => '01234567891231',
            'desc_tip'      => 'true',
            'description'   => __( 'Enter EAN-13 (13 digits barcode)', 'applause' )
        )
    );

    echo '</div>';
}

// Save EAN field

add_action('woocommerce_process_product_meta','applause_simple_product_ean_save');

function applause_simple_product_ean_save( $post_id ) {

    $ean_post = $_POST['_ean'];

    if( is_array($ean_post) ) {
        return;
    }

    if( isset($ean_post) ){
        update_post_meta( $post_id, '_ean', esc_attr( $ean_post ) );
    }

    $ean_data = get_post_meta( $post_id, '_ean', true );

    if ( empty( $ean_data ) ) {
        delete_post_meta( $post_id, '_ean', '' );
    }
}

// Variable products
// Display EAN field

add_action( 'woocommerce_product_after_variable_attributes', 'applause_variable_product_ean_field', 10, 3 );

function applause_variable_product_ean_field( $loop, $variation_data, $variation ) {

    echo '<div>';

    woocommerce_wp_text_input( 
        array( 
            'id'            => '_ean[' . $variation->ID . ']', 
            'label'         => __( 'EAN', 'applause' ), 
            // 'placeholder'   => '01234567891231',
            'desc_tip'      => 'true',
            'wrapper_class' => 'form-row',
            'description'   => __( 'Enter EAN-13 (13 digits barcode)', 'applause' ),
            'value'         => get_post_meta( $variation->ID, '_ean', true )
        )
    );

    echo '</div>';

}

// Save EAN field(s)

add_action( 'woocommerce_save_product_variation', 'applause_variable_product_ean_save', 10, 2 );

function applause_variable_product_ean_save( $post_id ) {
    
    $ean_post = $_POST['_ean'][$post_id];

    if( isset( $ean_post ) ) {
        update_post_meta( $post_id, '_ean', esc_attr( $ean_post ) );
    }

    $ean_data = get_post_meta( $post_id, '_ean', true );

    if ( empty( $ean_data ) ) {
        delete_post_meta( $post_id, '_ean', '' );
    }
    
}
