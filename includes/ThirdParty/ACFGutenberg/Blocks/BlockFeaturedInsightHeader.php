<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockFeaturedInsightHeader extends Blockable
{
    protected $block_name = 'block_featured_insight_header';

    protected $block_title = 'Header with featured insight';

    protected $block_category = 'headers';

    protected $block_icon = 'cover-image';

    protected $block_keywords = ['header', 'image'];

    protected $block_jsx = false;

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
        $context['options'] = get_fields('options');
        $context['featured_insight'] = $this->getMostRecentFeaturedInsight();


        Timber::render('blocks/headers/featured-insight-header.twig', $context);
    }

    public function getMostRecentFeaturedInsight (): array
    {
        $args = [
            'post_type' => 'insight',
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => 'is_show_as_featured',
                    'value' => true,
                    'compare' => '=',
                ],
            ],
            'no_found_rows' => true,
            'orderby' => 'date',
            'suppress_filters' => false,
        ];

        return get_posts($args);
    }
}
