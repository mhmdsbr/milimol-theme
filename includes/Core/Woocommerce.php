<?php
/**
 * All related functions for Woocommerce
 */
namespace EXP\Core;

class Woocommerce
{

    public function __construct()
    {

        add_action( 'after_setup_theme', [&$this, 'theme_add_woocommerce_support'] );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
    }

    function theme_add_woocommerce_support(): void
    {
        add_theme_support( 'woocommerce' );
    }



}
