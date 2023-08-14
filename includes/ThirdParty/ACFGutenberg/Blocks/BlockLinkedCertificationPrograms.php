<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockLinkedCertificationPrograms extends Blockable
{
    protected $block_name = 'block_linked_connection';

    protected $block_title = 'Linked connections';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['certification', 'services', 'industry', 'programs', 'list', 'overview'];

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

        if (!isset($context['fields']['selected_connection']) ) {
            return;
        }

        $templateName = '';
        $key = $context['fields']['selected_connection'];

        if ($key === 'p2p_certi_industry_program') {
            $templateName = 'linked-certification-industry-programs.twig';
        }
        elseif ($key === 'p2p_certi_service_industry') {
            $templateName = 'linked-certification-service-industry.twig';
        }
        elseif ($key === 'p2p_certi_service_program') {
            $templateName = 'linked-certification-service-program.twig';
        }


        if (isset($context['post_fields'][$key]) && is_countable($context['post_fields'][$key]) && count($context['post_fields'][$key]) > 0) {
            Timber::render("blocks/listings/{$templateName}", $context);
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
