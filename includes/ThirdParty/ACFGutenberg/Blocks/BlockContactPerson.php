<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockContactPerson extends Blockable
{
    protected $block_name = 'block_contact_person';

    protected $block_title = 'Contact person';

    protected $block_category = 'layout';

    protected $block_icon = 'format-status';

    protected $block_keywords = ['contact', 'person'];

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
            $context['options'] = get_fields('options');

            if (isset($context['fields']['selected_contact'])) {
                $context['contact_fields'] = get_fields($context['fields']['selected_contact'][0]);

                Timber::render('blocks/layout/contact-person.twig', $context);
            }

        }
    }
}
