<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockValuePropositions extends Blockable
{
    protected $block_name = 'block_value_propositions';

    protected $block_title = 'Value Propositions';

    protected $block_category = 'layout';

    protected $block_icon = 'table-row-before';

    protected $block_keywords = ['value', 'propositions'];

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

        Timber::render('blocks/layout/value-propositions.twig', $context);
    }
}
