<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockServicesListing extends Blockable
{
    protected $block_name = 'block_services_listing';

    protected $block_title = 'Services Listing';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['services', 'list', 'overview'];

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
        $context['block'] = $block;
        $context['fields'] = get_fields();
        $context['is_preview'] = $is_preview;
        $context['options'] = get_fields('options');

        $context['service_terms'] = get_terms(array(
            'taxonomy' => 'service_type',
            'hide_empty' => true,
        ));

        foreach ($context['service_terms'] as $key => $term) {
            $context['service_types'][$key]['name'] = $term->name;
            $context['service_types'][$key]['slug'] = $term->slug;
            $context['service_types'][$key]['id'] = $term->term_id;
            $context['service_types'][$key]['posts'] = $this->getServicesByTerms($term);
            $context['service_types'][$key]['icon'] = $this->getTermIcon($term);
        }

        $context['certi_services'] = $this->getCertificationServices();

        Timber::render('blocks/listings/services-listing.twig', $context);
    }

    public function getServicesByTerms($term): array
    {
        $args = [
            'post_type' => 'service',
            'orderby' => 'menu_order',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'service_type', // Replace with the actual name of the taxonomy
                    'field' => 'slug', // You can also use 'term_id', 'name', or 'term_taxonomy_id'
                    'terms' => $term->slug, // Replace with the actual slug of the term
                ),
            ),
            'posts_per_page' => -1,
            'no_found_rows' => true
        ];

        return get_posts($args);
    }

    public function getCertificationServices(): array
    {
        $args = [
            'post_type' => 'certi_service',
            'orderby' => 'menu_order',
            'order' => 'DESC',
            'posts_per_page' => -1,
            'no_found_rows' => true
        ];

        return get_posts($args);
    }

    public function getTermIcon ($term): string
    {
        $icon_field = get_field('custom_title_icon', $term);
        if (!isset($icon_field[0])) {
            return '';
        }
        $icon = get_field('custom_title_icon', $term)[0]['icons'] ?: null;
        return $icon;
    }
}
