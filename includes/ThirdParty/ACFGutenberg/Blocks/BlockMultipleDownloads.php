<?php
/**
 * Helper class for custom Contact Gutenberg block
 */
namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockMultipleDownloads extends Blockable
{
    protected $block_name = 'block_multiple_downloads';

    protected $block_title = 'Multiple Downloads';

    protected $block_category = 'layout';

    protected $block_icon = 'download';

    protected $block_keywords = ['multiple', 'download'];


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
        $context['block'] = $block;
        $context['fields'] = get_fields();
        $context['is_preview'] = $is_preview;
        Timber::render('blocks/layout/multiple-downloads.twig', $context);
    }
}
