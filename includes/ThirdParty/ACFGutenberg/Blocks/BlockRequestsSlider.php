<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockRequestsSlider extends Blockable
{
    protected $block_name = 'block_requests_slider';

    protected $block_title = 'درخواست های خرید';

    protected $block_category = 'slider';

    protected $block_icon = 'slides';

    protected $block_keywords = ['request', 'slider', 'buy', 'درخواست'];

    protected $block_jsx = true;

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
        $timber_post            = Timber::get_post();
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;
        $context['post_fields'] = get_fields($timber_post);


        $args_latest = array(
            'post_type' => 'request',
            'status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 10, // Display 10 latest products
        );
        $latest_requests = get_posts($args_latest);

        foreach ($latest_requests as $request) {

            $request_cas_no = get_the_terms($request->ID, 'request_cas_no');
            $request->request_cat_cas = $request_cas_no;

        }
        $context['requests'] = $latest_requests;

        Timber::render('blocks/sliders/requests-slider.twig', $context);
    }
}