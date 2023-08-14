<?php
/**
 * Helper class for custom Contact Gutenberg block
 */
namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockServiceTypeThreeTemplate extends Blockable
{
    protected $block_name = 'block_service_type_3_template';

    protected $block_title = 'Service Template type: 3 ';

    protected $block_category = 'templates';

    protected $block_icon = 'table-row-after';

    protected $block_keywords = ['template', 'blocks', 'service'];

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
        $context['blocks_template'] = [
            ['acf/block-split-content-header'],
            ['acf/block-anchor-menu'],
            ['acf/block-usp-accordion'],
            ['acf/block-content'],
            ['acf/block-image'],
            ['acf/block-content'],
            ['acf/block-linked-industry'],
            ['acf/block-related-or-sub-services-listing'],
            ['acf/block-banner'],
            ['acf/block-contact-person'],
        ];
        $context['template_lock'] = false; // Options: all, insert, false

        Timber::render('blocks/templates/innerblocks.twig', $context);
    }
}
