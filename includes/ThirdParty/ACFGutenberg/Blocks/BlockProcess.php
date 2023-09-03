<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockProcess extends Blockable
{
    protected $block_name = 'block_flow_process';

    protected $block_title = 'بلاک کارت ها';

    protected $block_category = 'process';

    protected $block_icon = 'slides';

    protected $block_keywords = ['process', 'timeline'];

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

        Timber::render('blocks/layout/process.twig', $context);
    }
}
