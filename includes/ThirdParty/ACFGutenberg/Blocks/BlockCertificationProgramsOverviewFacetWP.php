<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockCertificationProgramsOverviewFacetWP extends Blockable
{
    protected $block_name = 'block_certification_programs_overview_facet_wp';

    protected $block_title = 'Certification Program Overview (FacetWP)';

    protected $block_category = 'facet_wp';

    protected $block_icon = 'search';

    protected $block_keywords = ['Certification', 'programs', 'overview', 'search', 'facet', 'list'];

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

            Timber::render('blocks/facet-wp/certification-program-overview.twig', $context);
        }
    }
}
