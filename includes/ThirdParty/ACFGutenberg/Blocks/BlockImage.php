<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockImage extends Blockable
{
    protected $block_name = 'block_image';

    protected $block_title = 'Image box';

    protected $block_category = 'layout';

    protected $block_icon = 'format-image';

    protected $block_keywords = ['image', 'media'];

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
        $context['blocks_template'] = [['core/image']];
        $context['allowed_blocks'] = [['core/image']];
        $context['template_lock'] = 'all'; // Options: all, insert, false

        Timber::render('blocks/layout/image.twig', $context);
    }
}
