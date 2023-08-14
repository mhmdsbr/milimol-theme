<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockRelatedOrSubServicesListing extends Blockable
{
    protected $block_name = 'block_related_or_sub_services_listing';

    protected $block_title = 'Related or Sub- Services Listing';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['services', 'related', 'subservices', 'list', 'overview'];

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
            $context['post'] = $timber_post;
            $context['post_fields'] = get_fields($context['post']->ID);

            if (!isset($context['post_fields']['p2p_service_service'])) {
                return;
            }

        $context['related_services'] = $context['post_fields']['p2p_service_service'];
        Timber::render('blocks/listings/related-sub-services-listing.twig', $context);

    }
}
