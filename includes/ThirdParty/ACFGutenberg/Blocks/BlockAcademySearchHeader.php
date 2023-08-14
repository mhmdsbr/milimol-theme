<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockAcademySearchHeader extends Blockable
{
    protected $block_name = 'block_academy_search_header';

    protected $block_title = 'Header for academy with search';

    protected $block_category = 'headers';

    protected $block_icon = 'cover-image';

    protected $block_keywords = ['header', 'academy', 'search'];

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
        $timber_post           = Timber::get_post();
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;


        Timber::render('blocks/headers/academy-search-header.twig', $context);
    }
}
