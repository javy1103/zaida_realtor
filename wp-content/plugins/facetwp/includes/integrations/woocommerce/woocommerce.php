<?php

class FacetWP_Integration_WooCommerce
{

    function __construct() {
        add_action( 'wp_footer', array( $this, 'front_scripts' ), 30 );
    }


    /**
     * Run WooCommerce handlers on facetwp-refresh
     * @since 2.0.9
     */
    function front_scripts() {
        wp_enqueue_script( 'facetwp-woocommerce', FACETWP_URL . '/includes/integrations/woocommerce/woocommerce.js', array( 'jquery' ), FACETWP_VERSION );
    }
}


if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    new FacetWP_Integration_WooCommerce();
}
