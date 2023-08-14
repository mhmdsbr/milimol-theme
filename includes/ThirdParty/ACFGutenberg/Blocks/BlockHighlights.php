<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockHighlights extends Blockable
{
    protected $block_name = 'block_highlights';

    protected $block_title = 'بلاک هایلایت';

    protected $block_category = 'process';

    protected $block_icon = 'slides';

    protected $block_keywords = ['process', 'timeline' , 'highlight'];

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

        $context               = Timber::context();
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;

        Timber::render('blocks/layout/highlights.twig', $context);
    }
}
