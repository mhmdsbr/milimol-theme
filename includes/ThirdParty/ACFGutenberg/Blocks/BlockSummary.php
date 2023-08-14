<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockSummary extends Blockable
{
    protected $block_name = 'block_summary';

    protected $block_title = 'Summary';

    protected $block_category = 'layout';

    protected $block_icon = 'align-pull-left';

    protected $block_keywords = ['summary', 'list', 'usp', 'features'];

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
        $context['is_preview'] = $is_preview;

        Timber::render('blocks/layout/summary.twig', $context);
    }
}
