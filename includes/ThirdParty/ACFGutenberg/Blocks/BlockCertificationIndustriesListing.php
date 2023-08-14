<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockCertificationIndustriesListing extends Blockable
{
    protected $block_name = 'block_certification_industries_listing';

    protected $block_title = 'Certification industries listing';

    protected $block_category = 'facet_wp';

    protected $block_icon = 'search';

    protected $block_keywords = ['Certification', 'industries', 'overview', 'search', 'facet', 'list'];

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

            $context['certification_industries'] = $this->getCertificationIndustries();

            if (is_countable($context['certification_industries']) && count($context['certification_industries']) > 0) {
                Timber::render('blocks/listings/certification-industries-listing.twig', $context);
            }
        }
    }

    public function getCertificationIndustries(): array
    {
        $args = [
            'post_type' => 'certi_industry',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'no_found_rows' => true,
        ];

        return get_posts($args);
    }
}
