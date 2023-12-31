<?php
// Ensure Timber is activated
use Timber\Timber;

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
$context['brand_filter'] = $brand_filter;

$grade_filter = isset($_GET['product_grade']) ? ($_GET['product_grade']) : array();
$context['grade_filter'] = $grade_filter;

$country_filter = isset($_GET['product_country']) ? ($_GET['product_country']) : array();
$context['country_filter'] = $country_filter;

$location_filter = isset($_GET['product_location']) ? ($_GET['product_location']) : array();
$context['location_filter'] = $location_filter;

$supplier_filter = isset($_GET['product_supplier_linked']) ? ($_GET['product_supplier_linked']) : array();
$context['supplier_filter'] = $supplier_filter;

$unit_filter = isset($_GET['product_unit']) ? ($_GET['product_unit']) : array();
$context['unit_filter'] = $unit_filter;

$min_order_filter = isset($_GET['min_order_quantity']) ? intval($_GET['min_order_quantity']) : 0;
$context['min_order_filter'] = $min_order_filter;

$product_purity_filter = isset($_GET['product_purity_filter']) ? intval($_GET['product_purity_filter']) : 0;
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

    global $argsGenerator;
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;

    if (!is_shop()) {
        // Set category context
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

        $args = $argsGenerator->generate_arguments();
        $context['products'] = Timber::get_posts($args);
        // Render appropriate template
        $template_name = ($context['cas'] && $queried_object instanceof WP_Term)
            ? 'templates/archive-product-cas.twig'
            : 'templates/archive-product.twig';
        Timber::render($template_name, $context);
    }
    else {
        // This is the main shop page; display all products
        $args = $argsGenerator->generate_arguments();
        $context['products'] = Timber::get_posts($args);
        // Render appropriate template for the main shop page
        Timber::render('templates/archive-product.twig', $context);
    }
}
