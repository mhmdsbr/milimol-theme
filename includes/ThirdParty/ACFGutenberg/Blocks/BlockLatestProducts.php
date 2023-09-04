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

        // Check if selected products are available in the block fields
        if (!empty($context['fields']['selected_products'])) {
            $selectedProductIDs = $context['fields']['selected_products'];

            $selected_products = array();

            foreach ($selectedProductIDs as $productID) {
                $product = wc_get_product($productID);

                // Get the image URLs for each selected product
                if ($product) {
                    $product_image_id = $product->get_image_id();
                    if ($product_image_id) {
                        $product_image = new Image($product_image_id);
                        $product->image_url = $product_image;
                    }

                    $product_categories = get_the_terms($productID, 'product_cat');
                    $product->product_cat = $product_categories;
                    $selected_products[] = $product;

                    $product_cas_no = get_the_terms($productID, 'product_cas_no');
                    $product->product_cat_cas = $product_cas_no;
                    $selected_products[] = $product;

                    $product_purity = get_field('product_purity', $product->get_id());
                    $product->product_purity = $product_purity;
                    $selected_products[] = $product;

                    // Get the associated company from the custom ACF relationship field
                    $associated_company = get_field('product_supplier_linked', $product->get_id());
                    $product->associated_company = $associated_company;
                }
            }

            $context['products'] = $selected_products;

        } elseif (!empty($context['fields']['latest_product'])) {
            // If no selected products, get the latest 6 WooCommerce products
            $args_latest = array(
                'post_type' => 'product',
                'status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => 10, // Display 10 latest products
            );

            $latest_products = wc_get_products($args_latest);

            foreach ($latest_products as $product) {

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
            }

            $context['products'] = $most_searched_products;

        }

        Timber::render('blocks/sliders/latest-products.twig', $context);
    }
}
