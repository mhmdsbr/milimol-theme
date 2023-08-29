<?php
// Ensure Timber is activated
if (!class_exists('Timber')) {
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
    return;
}

$context = Timber::context();
// Common context setup for all cases
$context['post'] = Timber::get_post();

// Retrieve unique CAS numbers associated with products in product_cas_no taxonomy
$cas_numbers = get_terms(array(
    'taxonomy' => 'product_cas_no',
    'hide_empty' => true,
));
$context['cas_numbers'] = $cas_numbers;

$brand_filter = isset($_GET['product_brand']) ? ($_GET['product_brand']) : array();
$country_filter = isset($_GET['product_country']) ? ($_GET['product_country']) : array();
$supplier_filter = isset($_GET['product_supplier_linked']) ? ($_GET['product_supplier_linked']) : array();
$unit_filter = isset($_GET['product_unit']) ? ($_GET['product_unit']) : array();
$min_order_filter = isset($_GET['min_order_quantity']) ? intval($_GET['min_order_quantity']) : 0;
$product_purity_filter = isset($_GET['product_purity_filter']) ? intval($_GET['product_purity_filter']) : 0;

$context['brand_filter'] = $brand_filter;
$context['country_filter'] = $country_filter;
$context['supplier_filter'] = $supplier_filter;
$context['unit_filter'] = $unit_filter;
$context['min_order_filter'] = $min_order_filter;
$context['product_purity_filter'] = $product_purity_filter;


if (is_singular('product')) {
    $product = wc_get_product($context['post']->ID);
    $context['product'] = $product;

    // Get related products
    $related_limit = -1;
    $related_ids = wc_get_related_products($context['post']->id, $related_limit);
    $context['related_products'] = Timber::get_posts($related_ids);

    // Render single product template
    Timber::render('templates/single-product.twig', $context);
} else {
    // Query setup
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );

    // Add Brand filter to the query
    if (!empty($_GET['product_brand'])) {
        $args['meta_query'] = array(
            array(
                'key'     => 'product_brand',
                'value'   => $brand_filter,
                'compare' => 'IN',
            ),
        );
    }

    // Add Country filter to the query
    if (!empty($_GET['product_country'])) {
        $args['meta_query'] = array(
            array(
                'key'     => 'product_country',
                'value'   => $country_filter,
                'compare' => 'IN',
            ),
        );
    }

    // Add Supplier filter to the query
    if (!empty($_GET['product_supplier_linked'])) {
        $args['meta_query'] = array(
            array(
                'key'     => 'product_supplier_linked',
                'value'   => $supplier_filter,
                'compare' => 'IN',
            ),
        );
    }

    // Add Weight filter to the query
    if (!empty($_GET['product_unit'])) {
        $args['meta_query'] = array(
            array(
                'key' => 'product_unit',
                'value' => $unit_filter,
                'compare' => 'IN',
            ),
        );
    }

    // Add Min order filter to the query
    if ($min_order_filter > 0) {
        $args['meta_query'][] = array(
            'key' => 'product_order_quantity',
            'value' => array(0, $min_order_filter),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC',
        );
    }
    // Add product purity filter to the query
    if ($product_purity_filter > 0) {
        $args['meta_query'][] = array(
            'key' => 'product_purity',
            'value' => array(0, $product_purity_filter),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC',
        );
    }


    // Fetch and set product posts
    $posts = Timber::get_posts($args);
    $context['products'] = $posts;

    // Set category context
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $context['category'] = get_term($term_id, 'product_cat');
    $context['cas'] = get_term($term_id, 'product_cas_no');
    $cas_image_url = get_field('cas_image', $context['cas']);
    $context['cas_image'] = $cas_image_url;
    $cas_fields = get_fields($context['cas']);
    $context['cas_fields'] = $cas_fields;

    // Set category thumbnail
    $category_thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
    if ($category_thumbnail_id) {
        $category_thumbnail = wp_get_attachment_image_src($category_thumbnail_id, 'medium');
        if ($category_thumbnail) {
            $context['product_cat_image_url'] = $category_thumbnail[0];
        }
    }

    // Render appropriate template
    $template_name = ($context['cas'] && $queried_object instanceof WP_Term)
        ? 'templates/archive-product-cas.twig'
        : 'templates/archive-product.twig';
    Timber::render($template_name, $context);
}


