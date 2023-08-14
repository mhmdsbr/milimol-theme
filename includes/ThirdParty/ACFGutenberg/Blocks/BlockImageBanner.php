<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockImageBanner extends Blockable
{
    protected $block_name = 'block_image_banner';

    protected $block_title = 'بنر تصویر';

    protected $block_category = 'layout';

    protected $block_icon = 'cover-image';

    protected $block_keywords = ['image', 'banner', 'cover', 'text', 'highlight'];

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

        Timber::render('blocks/layout/image-banner.twig', $context);
    }
}
