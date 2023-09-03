<?php
/**
 * Helper class for custom Follow Us Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockFollowUs extends Blockable
{
    protected $block_name = 'block_follow_us';

    protected $block_title = 'ما را دنبال کنید';

    protected $block_category = 'layout';

    protected $block_icon = 'share';

    protected $block_keywords = ['follow', 'share', 'sharing', 'social', 'media'];

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
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['options']    = get_fields('options');
        $context['is_preview'] = $is_preview;

        Timber::render('blocks/layout/follow-us.twig', $context);
    }
}
