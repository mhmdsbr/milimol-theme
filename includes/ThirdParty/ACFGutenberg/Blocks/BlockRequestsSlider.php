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

        $collectRequests = [];

        $context['requests'] = Timber::get_posts([
            'post_type' => 'request',
            'posts_per_page' => 10,
            'post_status' => 'publish',
            'post__in' => $collectRequests,
        ]);

        if (empty($context['requests'])) {
            return;
        }
        Timber::render('blocks/sliders/requests-slider.twig', $context);
    }
}