<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockProcessSlider extends Blockable
{
    protected $block_name = 'block_process_slider';

    protected $block_title = 'اسلایدر فرآیند ها';

    protected $block_category = 'layout';

    protected $block_icon = 'slides';

    protected $block_keywords = ['process', 'slider'];

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

        if ( isset($context['fields']['selected_process'])
            && is_countable($context['fields']['selected_process'])
            && count($context['fields']['selected_process']) > 0
        ) {
            $context['process_fields'] = get_fields($context['fields']['selected_process'][0]);
            Timber::render('blocks/sliders/process-slider.twig', $context);
        }
    }
}
