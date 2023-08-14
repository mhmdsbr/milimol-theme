<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockInsightHeader extends Blockable
{
    protected $block_name = 'block_insight_header';

    protected $block_title = 'Header for insights';

    protected $block_category = 'headers';

    protected $block_icon = 'cover-image';

    protected $block_keywords = ['header', 'image', 'insight'];

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
        $context               = Timber::context();
        $timber_post           = Timber::get_post();
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;
        $context['post'] = $timber_post;
        $context['post_fields'] = get_fields($context['post']->ID);
        $context['insight_types'] = get_the_terms($context['post']->ID, 'insight_type');

        Timber::render('blocks/headers/insight-header.twig', $context);
    }
}
