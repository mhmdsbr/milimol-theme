<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockLatestInsightSlider extends Blockable
{
    protected $block_name = 'block_latest_insight_slider';

    protected $block_title = 'آخرین درخواست های خرید';

    protected $block_category = 'slider';

    protected $block_icon = 'slides';

    protected $block_keywords = ['request', 'slider', 'buy'];

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

        $collectInsights = [];

        $context['latest_insights'] = Timber::get_posts([
            'post_type' => 'insight',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'post__in' => $collectInsights,
        ]);

        if (empty($context['latest_insights'])) {
            return;
        }
        Timber::render('blocks/sliders/latest-insight-slider.twig', $context);
    }
}