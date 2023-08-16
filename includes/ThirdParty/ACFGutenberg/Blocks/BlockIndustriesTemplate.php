<?php
/**
 * Helper class for custom Contact Gutenberg block
 */
namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockIndustriesTemplate extends Blockable
{
    protected $block_name = 'block_industries_template';

    protected $block_title = 'Industries Template';

    protected $block_category = 'templates';

    protected $block_icon = 'table-row-after';

    protected $block_keywords = ['template', 'blocks', 'industries'];

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
        $context = Timber::context();
        $context['block'] = $block;
        $context['fields'] = get_fields();
        $context['is_preview'] = $is_preview;
        $context['blocks_template'] =array(
            'acf/block_industry_listing'
        );
        var_dump($context['blocks_template']);
        $context['template_lock'] = false; // Options: all, insert, false
        Timber::render('blocks/templates/innerblocks.twig', $context);
    }
}