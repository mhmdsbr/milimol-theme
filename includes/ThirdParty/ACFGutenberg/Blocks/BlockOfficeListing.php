<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockOfficeListing extends Blockable
{
    protected $block_name = 'block_office_listing';

    protected $block_title = 'Office Listing';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['office', 'list', 'overview'];

    /**
     * Callback method that displays the block
     *
     * @param array   $block
     * @param string  $content
     * @param boolean $is_preview
     *
     * @return void
     */
    public function renderCallback(array $block, string $content = '', bool $is_preview = true): void
    {
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;
        $context['regions'] = $this->getRegions('office_region');
        Timber::render('blocks/listings/offices-listing.twig', $context);
    }

    public function getRegions(string $taxonomy): array
    {
        $regions = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => true,
            'parent'     => 0,
        ]);

        if (count($regions) > 0) {
            foreach ($regions as $region) {
                $region->subregions = $this->getSubRegions($region->term_id);
            }
        }

        return $regions;
    }

    public function getSubRegions(int $termID): array
    {
        $parent_term_id = $termID; // term id of parent term (edited missing semi colon)

        $taxonomies = [
            'office_region',
        ];

        $args = [
            'parent' => $parent_term_id,
             'child_of'      => $parent_term_id,
        ];

        $terms = get_terms($taxonomies, $args);

        if (count($terms) > 0) {
            foreach ($terms as $term) {
                $term->offices = $this->getOfficesBySubRegion($term->term_id);
            }
        }

        return $terms;
    }

    public function getOfficesBySubRegion($termID): array
    {
        $args = [
            'post_type'      => 'office',
            'orderby'        => 'title',
            'order'          => 'DESC',
            'posts_per_page' => - 1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'office_region',
                    'field' => 'term_id',
                    'terms' => $termID,
                ),
            ),
            'no_found_rows'  => true,
        ];

        return get_posts($args);
    }
}
