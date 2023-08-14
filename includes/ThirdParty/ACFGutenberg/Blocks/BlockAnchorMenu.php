<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockAnchorMenu extends Blockable
{
    protected $block_name = 'block_anchor_menu';

    protected $block_title = 'Anchor Menu (below headers)';

    protected $block_category = 'headers';

    protected $block_icon = 'admin-links';

    protected $block_keywords = ['header', 'anchor', 'menu', 'link', 'scroll'];

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
        if(!wp_is_mobile()) {
            $context['block']      = $block;
            $context['fields']     = get_fields();
            $context['is_preview'] = $is_preview;

            Timber::render('blocks/ux-components/anchor-menu.twig', $context);
        }
    }
}
