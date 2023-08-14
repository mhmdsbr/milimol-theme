<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockIndustryListing extends Blockable
{
    protected $block_name = 'block_industry_listing';

    protected $block_title = 'لیست شرکت ها';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['industries', 'industry', 'list', 'overview'];

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
        $context['industries'] = $this->getIndustries();

        // Get all industries
        $allIndustries = $this->getIndustries();
        // Check the checkbox value
        $showAllIndustries = isset($context['fields']['show_all_industries']) && $context['fields']['show_all_industries'];

        // Prepare the data based on the checkbox value
        if ($showAllIndustries) {
            // Show all industries
            $context['industries'] = $allIndustries;
        } else {
            // Show the 6 latest companies
            $context['industries'] = array_slice($allIndustries, 0, 6);
        }

        if (count($context['industries']) > 0) {
            Timber::render('blocks/listings/industries-listing.twig', $context);
        }
    }

    public function getIndustries(): array
    {
        $args = [
            'post_type' => 'industry',
            'orderby' => 'menu_order',
            'order' => 'DESC',
            'posts_per_page' => -1,
            'no_found_rows' => true
        ];

        return get_posts($args);
    }
}
