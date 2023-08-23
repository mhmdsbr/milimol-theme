<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */
use Timber\Image;

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

$args_company_products = array(
    'post_type' => 'product',
    'status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => 10, // Display six latest products
);

$company_products = wc_get_products($args_company_products);

foreach ($company_products as $product) {


    //Get the image URLs for each latest product
    $product_image_id = $product->get_image_id();
    if ($product_image_id) {
        $product_image = new Image($product_image_id);
        $product->image_url = $product_image;
    }

    $product_categories = get_the_terms($product->get_id(), 'product_cat');
    $product->product_cat = $product_categories;

    $product_cas_no = get_the_terms($product->get_id(), 'product_cas_no');
    $product->product_cat_cas = $product_cas_no;


    $product_purity = get_field('product_purity', $product->get_id());
    $product->product_purity = $product_purity;

    // Get the associated company from the custom ACF relationship field
    $associated_company = get_field('product_supplier_linked', $product->get_id());
    $product->associated_company = $associated_company;

}

$context['products'] = $company_products;

if ( post_password_required( $timber_post->ID ) ) {
    Timber::render( 'single-password.twig', $context );
} else {
    Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}

