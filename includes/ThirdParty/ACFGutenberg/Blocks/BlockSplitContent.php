<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockSplitContent extends Blockable
{
    protected $block_name = 'block_split_content';

    protected $block_title = 'بلاک متن و تصویر';

    protected $block_category = 'layout';

    protected $block_icon = 'format-image';

    protected $block_keywords = ['image', 'media', 'text', 'content'];

    protected $block_jsx = false;

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


        Timber::render('blocks/layout/split-content.twig', $context);
    }
}
