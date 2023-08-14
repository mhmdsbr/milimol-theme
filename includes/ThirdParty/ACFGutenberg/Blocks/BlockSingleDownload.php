<?php
/**
 * Helper class for custom Single Download Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockSingleDownload extends Blockable
{
    protected $block_name = 'block_single_download';

    protected $block_title = 'Single download';

    protected $block_category = 'layout';

    protected $block_icon = 'download';

    protected $block_keywords = ['single', 'download'];

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

        if (!empty($context['fields']['download']) && !empty($context['fields']['download']['url'])) {
            $context['download'] = $context['fields']['download']['url'];
        }

        Timber::render('blocks/layout/single-download.twig', $context);
    }
}
