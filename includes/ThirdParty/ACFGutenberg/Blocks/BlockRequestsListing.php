<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockRequestsListing extends Blockable
{
    protected $block_name = 'block_requests_listing';

    protected $block_title = 'لیست درخواست ها';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['request', 'لیست', 'buy', 'درخواست'];

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
        $timber_post            = Timber::get_post();
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;
        $context['post_fields'] = get_fields($timber_post);


        $context['requests'] = Timber::get_posts([
            'post_type' => 'request',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        if (empty($context['requests'])) {
            return;
        }

        foreach ($context['requests'] as $request) {
            $request_cas_no_terms = get_the_terms($request->ID, 'request_cas_no');
            if (!empty($request_cas_no_terms)) {
                $request->cas_no_terms = $request_cas_no_terms;
            }
        }

        Timber::render(array('blocks/listings/requests-listing.twig'), $context);
    }
}