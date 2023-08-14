<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockCasesSlider extends Blockable
{
    protected $block_name = 'block_cases_slider';

    protected $block_title = 'Cases slider';

    protected $block_category = 'sliders';

    protected $block_icon = 'slides';

    protected $block_keywords = ['slider', 'cases'];

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

        Timber::render('blocks/sliders/cases-slider.twig', $context);
    }
}
