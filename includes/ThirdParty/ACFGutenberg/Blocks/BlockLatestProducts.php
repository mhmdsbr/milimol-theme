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

    protected $block_title = 'آخرین محصولات';

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

            // Get the image URLs for each selected product
            foreach ($selectedProductIDs as $productID) {
                $product = wc_get_product($productID);

                if ($product) {
                    $product_image_id = $product->get_image_id();
                    if ($product_image_id) {
                        $product_image = new Image($product_image_id);
                        $product_image_url = $product_image->src('thumbnail');
                        $product->image_url = $product_image_url;
                    }

                    $product_categories = get_the_terms($productID, 'product_cat');
                    $product->categories = $product_categories;
                    $selected_products[] = $product;

                    // Get the associated company from the custom ACF relationship field
                    $associated_company = get_field('product_supplier_linked', $product->get_id());
                    $product->associated_company = $associated_company;
                }
            }

            $context['products'] = $selected_products;

        } else {
            // If no selected products, get the latest 6 WooCommerce products
            $args_latest = array(
                'post_type' => 'product',
                'status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => 6, // Display six latest products
            );

            $latest_products = wc_get_products($args_latest);

            // Get the image URLs for each latest product
            foreach ($latest_products as $product) {
                $product_image_id = $product->get_image_id();
                if ($product_image_id) {
                    $product_image = new Image($product_image_id);
                    $product_image_url = $product_image->src('thumbnail');
                    $product->image_url = $product_image_url;
                }

                $product_categories = get_the_terms($product->get_id(), 'product_cat');
                $product->categories = $product_categories;

                $product_cas_no = get_the_terms($product->get_id(), 'product_cas_no');
                $product->categories = $product_cas_no;


                $product_purity = get_field('product_purity', $product->get_id());
                $product->product_purity = $product_purity;

                // Get the associated company from the custom ACF relationship field
                $associated_company = get_field('product_supplier_linked', $product->get_id());
                $product->associated_company = $associated_company;
            }

            $context['products'] = $latest_products;
        }

        Timber::render('blocks/sliders/latest-products.twig', $context);
    }
}
