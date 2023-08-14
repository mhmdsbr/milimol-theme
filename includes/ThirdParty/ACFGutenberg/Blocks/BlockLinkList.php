<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockLinkList extends Blockable
{
    protected $block_name = 'block_linklist';

    protected $block_title = 'Linklist (with icons)';

    protected $block_category = 'layout';

    protected $block_icon = 'editor-ul';

    protected $block_keywords = ['list', 'list', 'icons', 'content'];

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
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;

        Timber::render('blocks/layout/linklist.twig', $context);
    }
}
