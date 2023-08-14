<?php
/**
 * Helper class for custom Contact Gutenberg block
 */
namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockSplitContentHeader extends Blockable
{
    protected $block_name = 'block_split_content_header';

    protected $block_title = 'Header for page/post with split content';

    protected $block_category = 'headers';

    protected $block_icon = 'cover-image';

    protected $block_keywords = ['header', 'image', 'split', 'content'];

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
        $context = Timber::context();
        $context['block'] = $block;
        $context['fields'] = get_fields();
        $context['is_preview'] = $is_preview;

        Timber::render('blocks/headers/split-content-header.twig', $context);
    }
}
