<?php
/**
 * Helper class for custom Single Download Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockQuote extends Blockable
{
    protected $block_name = 'block_quote';

    protected $block_title = 'Quote Block';

    protected $block_category = 'layout';

    protected $block_icon = 'editor-quote';

    protected $block_keywords = ['block', 'quote'];

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

        Timber::render('blocks/layout/quote.twig', $context);
    }
}
