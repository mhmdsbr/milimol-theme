<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockImageHeader extends Blockable
{
    protected $block_name = 'block_image_header';

    protected $block_title = 'سربرگ با تصویر پس زمینه';

    protected $block_category = 'headers';

    protected $block_icon = 'cover-image';

    protected $block_keywords = ['header', 'image'];
    
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
        $context               = Timber::context();
        $timber_post           = Timber::get_post();
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;
        $context['post'] = $timber_post;
        $context['allowed_blocks'] = [ 'core/cover'];
        $context['inner_blocks_template'] = [['core/cover', ['core/post-title']]];

        Timber::render('blocks/headers/image-header.twig', $context);
    }
}
