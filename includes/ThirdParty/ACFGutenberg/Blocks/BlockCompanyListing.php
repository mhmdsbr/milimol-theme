<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockCompanyListing extends Blockable
{
    protected $block_name = 'block_company_listing';

    protected $block_title = 'لیست شرکت ها';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['company', 'companies', 'list', 'overview', 'شرکت'];

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
        $context['companies'] = $this->getCompanies();

        // Get all industries
        $allCompanies = $this->getCompanies();
        // Check the checkbox value
        $showAllCompanies = isset($context['fields']['show_all_companies']) && $context['fields']['show_all_companies'];

        // Prepare the data based on the checkbox value
        if ($showAllCompanies) {
            // Show all industries
            $context['companies'] = $allCompanies;
        } else {
            // Show the 6 latest companies
            $context['companies'] = array_slice($allCompanies, 0, 6);
        }

        if (count($context['companies']) > 0) {
            Timber::render('blocks/listings/companies-listing.twig', $context);
        }
    }

    public function getCompanies(): array
    {
        $args = [
            'post_type' => 'company',
            'orderby' => 'menu_order',
            'order' => 'DESC',
            'posts_per_page' => -1,
            'no_found_rows' => true
        ];

        return get_posts($args);
    }
}
