<?php

if ( ! class_exists( 'Timber' ) ) {
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';

    return;
}

$context            = Timber::context();
$context['sidebar'] = Timber::get_widgets( 'shop-sidebar' );

if ( is_singular( 'product' ) ) {
    $context['post']    = Timber::get_post();
    $product            = wc_get_product( $context['post']->ID );
    $context['product'] = $product;

    // Get related products
    $related_limit               = -1;
    $related_ids                 = wc_get_related_products( $context['post']->id, $related_limit );
    $context['related_products'] =  Timber::get_posts( $related_ids );

    // Restore the context and loop back to the main query loop.
    wp_reset_postdata();

    Timber::render( 'templates/single-product.twig', $context );
} else {
    $posts = Timber::get_posts();
    $context['products'] = $posts;
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $context['category'] = get_term( $term_id, 'product_cat' );
    $context['cas'] = get_term( $term_id, 'product_cas_no' );
    $cas_image_url = get_field( 'cas_image', $context['cas'] );
    $context['cas_image'] = $cas_image_url;
    $cas_fields = get_fields( $context['cas'] ); // Retrieve all ACF fields for the term
    $context['cas_fields'] = $cas_fields; // Pass the fields to the context
    // Get the product_cat thumbnail image URL
    $category_thumbnail_id = get_term_meta( $term_id, 'thumbnail_id', true );
    if ( $category_thumbnail_id ) {
        $category_thumbnail = wp_get_attachment_image_src( $category_thumbnail_id, 'medium' );
        if ( $category_thumbnail ) {
            $context['product_cat_image_url'] = $category_thumbnail[0];
        }
    }


    if ( get_term( $term_id, 'product_cas_no' ) ) {

        Timber::render( 'templates/archive-product-cas.twig', $context );

    } else {

        Timber::render( 'templates/archive-product.twig', $context );

    }

}