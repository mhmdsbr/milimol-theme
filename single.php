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
use Timber\Timber;

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;
$postType = get_post_type($timber_post);


switch ($postType) {
    case 'company':
        $args_company_products = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
            'meta_query'    => array(
                'relation'      => 'AND',
                array(
                    'key'       => 'product_supplier_linked',
                    'value'     => '"' . $timber_post->ID . '"',
                    'compare'   => 'LIKE',
                ),
            ),
        );
        $company_products = new WP_Query($args_company_products);

        $productArray = [];
        foreach ($company_products->posts as $product_post_object) {
            $product = wc_get_product($product_post_object->ID);

            //Get the image URLs for each latest product
            $product_image_id = $product->get_image_id();
            if ($product_image_id) {
                $product_image = new Image($product_image_id);
                $product->image_url = $product_image;
            }

            $product_link = $product->get_permalink();
            $product->product_link = $product_link;

            $product_categories = get_the_terms($product->get_id(), 'product_cat');
            $product->product_cat = $product_categories;

            $product_cas_no = get_the_terms($product->get_id(), 'product_cas_no');
            $product->product_cat_cas = $product_cas_no;

            $product_purity = get_field('product_purity', $product->get_id());
            $product->product_purity = $product_purity;


            $productArray[] = $product;
        }
        $context['products'] = $productArray;

        // Retrieve the ACF field "company_map" value
        $leafletMapData = get_field('company_map');
        if ($leafletMapData) {
            // Add the map data to the context
            $context['leafletMapData'] = $leafletMapData;

        }

        // Retrieve Company Gallery img Urls
        $company_gallery_ids = get_field('company_img_gallery');
        $company_gallery_img_urls = array();

        if ($company_gallery_ids) {
            foreach ($company_gallery_ids as $image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'full');
                if ($image_url) {
                    $company_gallery_img_urls[] = $image_url;
                }
            }
        }
        $context['company_gallery_img_urls'] = $company_gallery_img_urls;

        break;

    case 'request':

        $terms = wp_get_post_terms($timber_post->ID, 'request_cas_no', array("fields" => "all"));
        foreach ($terms as $term) {
            $request_cas_no = $term->name;
        }
        $context['requestCas'] = $request_cas_no;

        break;


}



Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );

