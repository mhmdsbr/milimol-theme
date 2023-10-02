<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use Timber\Image;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockLatestProducts extends Blockable
{
    protected $block_name = 'block_latest_products';

    protected $block_title = 'محصولات';

    protected $block_category = 'slider';

    protected $block_icon = 'slides';

    protected $block_keywords = ['latest', 'product', 'slide', 'محصول'];

    /**
     * Callback method that displays the block
     *
     * @param array $block
     * @param string $content
     * @param boolean $is_preview
     *
     * @return void
     */
    public function renderCallback(array $block, string $content = '', bool $is_preview = true): void
    {
        $context['block'] = $block;
        $context['fields'] = get_fields();
        $context['is_preview'] = $is_preview;

        $is_show_product = $context['fields']['is_show_product'];

        // Check if selected products are available in the block fields
        if ($is_show_product == 'select_product') {

            $selectedProducts = $context['fields']['selected_products'];
            foreach ($selectedProducts as $product) {

                $productID = $product->ID; // Get the product ID
                if ($product) {

                    // Get the image URLs for each selected product
                    $product_categories = get_the_terms($productID, 'product_cat');
                    $product->product_cat = $product_categories;

                    $product_cas_no = get_the_terms($productID, 'product_cas_no');
                    $product->product_cat_cas = $product_cas_no;

                    $product_purity = get_field('product_purity', $product->ID);
                    $product->product_purity = $product_purity;

                    // Get the associated company from the custom ACF relationship field
                    $associated_company = get_field('product_supplier_linked', $product->ID);
                    $product->associated_company = $associated_company;
                }

                $product_link = get_permalink($product);
                $product->link = $product_link;
            }

            $context['products'] = $selectedProducts;

        } elseif ($is_show_product == 'latest_product') {
            // If no selected products, get the latest 6 WooCommerce products
            $args_latest = array(
                'post_type' => 'product',
                'status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => 8, // Display 10 latest products
            );
            $latest_products = get_posts($args_latest);

            foreach ($latest_products as $product) {

                $product_categories = get_the_terms($product->ID, 'product_cat');
                $product->product_cat = $product_categories;

                $product_cas_no = get_the_terms($product->ID, 'product_cas_no');
                $product->product_cat_cas = $product_cas_no;


                $product_purity = get_field('product_purity', $product->ID);
                $product->product_purity = $product_purity;

                // Get the associated company from the custom ACF relationship field
                $associated_company = get_field('product_supplier_linked', $product->ID);
                $product->associated_company = $associated_company;

                $product_link = get_permalink($product);
                $product->link = $product_link;
            }

            $context['products'] = $latest_products;

        } else { // show the most searched product
            $args_most_searched = array(
                'post_type' => 'product',
                'status' => 'publish',
                'meta_key'       => 'searched_numbers', // Specify the ACF custom field name
                'orderby'        => 'meta_value_num',    // Order by the numeric value of the custom field
                'order'          => 'DESC', // Order by the numeric value of the custom field
                'posts_per_page' => 12, // Display 12 latest products
            );

            $most_searched_products = wc_get_products($args_most_searched);

            foreach ($most_searched_products as $product) {

                // Get the image URLs for each latest product
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

                $product_link = $product->get_permalink();
                $product->link = $product_link;
            }

            $context['products'] = $most_searched_products;

        }

        Timber::render('blocks/sliders/latest-products.twig', $context);
    }
}
