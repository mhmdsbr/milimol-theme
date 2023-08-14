<?php
/**
 * Helper class for custom Contact Form Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockContactForm extends Blockable
{
    protected $block_name = 'block_contact_form';

    protected $block_title = 'Contact form';

    protected $block_category = 'layout';

    protected $block_icon = 'phone';

    protected $block_keywords = ['contact', 'form'];

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

        Timber::render('blocks/layout/contact-form.twig', $context);
    }
}
