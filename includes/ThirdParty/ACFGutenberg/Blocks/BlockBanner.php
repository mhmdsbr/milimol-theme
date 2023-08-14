<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockBanner extends Blockable
{
    protected $block_name = 'block_banner';

    protected $block_title = 'Banner';

    protected $block_category = 'layout';

    protected $block_icon = 'align-wide';

    protected $block_keywords = ['banner', 'call to action', 'cta', 'event'];

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

        if (isset($context['fields']['selected_banner']) && count($context['fields']['selected_banner']) > 0) {
            $context['banner_fields'] = get_fields($context['fields']['selected_banner'][0]);
            $currentDate = date('j M Y');
            if ($context['banner_fields']['is_event'] === true && $context['banner_fields']['is_hide_after_due_date'] === true && strtotime($context['banner_fields']['event_date']) < strtotime($currentDate)) {
               return;
            }

            Timber::render('blocks/layout/banner.twig', $context);
        }
    }
}
