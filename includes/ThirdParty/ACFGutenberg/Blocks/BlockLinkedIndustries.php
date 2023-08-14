<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockLinkedIndustries extends Blockable
{
    protected $block_name = 'block_linked_industry';

    protected $block_title = 'Linked Industries';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['industries', 'industry', 'list', 'overview', 'services'];

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
        $timber_post           = Timber::get_post();
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;
        $context['post_fields'] = get_fields($timber_post);

        if (isset($context['post_fields']['p2p_service_industry']) && is_countable($context['post_fields']['p2p_service_industry']) && count($context['post_fields']['p2p_service_industry']) > 0) {
            Timber::render('blocks/listings/linked-industries.twig', $context);
        }

    }

    public function getIndustries(): array
    {
        $args = [
            'post_type'      => 'industry',
            'orderby'        => 'menu_order',
            'order'          => 'DESC',
            'posts_per_page' => -1,
            'no_found_rows'  => true
        ];

        return get_posts($args);
    }
}
