<?php
/**
 * Custom functionality to alter the default Guteberg behaviour
 */
namespace EXP\Core;

use EXP\ThirdParty\ACFGutenberg\Blocks\Block;
use EXP\ThirdParty\ACFGutenberg\Parts\Part;

class Gutenberg
{
    public function __construct()
    {
        add_filter('allowed_block_types_all', [&$this, 'setAllowedBlocks'], 10, 1);
        add_filter('render_block', [&$this, 'modifyBlockOutput'], 10, 2);
    }

    /**
     * Set the allowed Gutenberg blocks
     *
     * @param bool|array $allowed_blocks
     * @return array
     */
    public function setAllowedBlocks($allowed_blocks) : array
    {
        $allowed_blocks = [
            // Core
            'core/buttons',
            'core/heading',
            'core/image',
            'core/list',
            'core/paragraph',
            'core/search',
            'core/quote',

            // Plugin
            'gravityforms/form',

            // ACF Blocks
            ...Block::getBlockNames(),

            // ACF Parts
            ...Part::getBlockNames(),
        ];

        return $allowed_blocks;
    }

    /**
     * Modify the output of the default Gutenberg blocks
     *
     * @param string $block_content
     * @param array $block
     * @return string
     */
    public function modifyBlockOutput(string $block_content, array $block) : string
    {
        if ($block['blockName'] === 'core/list') {
            return sprintf('<div class="wp-list">%s</div>', $block_content);
        }

        if ($block['blockName'] === 'core/heading' || $block['blockName'] === 'core/image') {
            return sprintf('<div class="container">%s</div>', $block_content);
        }

        if ($block['blockName'] === 'core/quote') {
            return sprintf('<div class="container"><div class="row"><div class="col-md-10 offset-md-1">%s</div></div></div>', $block_content);
        }

        return $block_content;
    }
}
