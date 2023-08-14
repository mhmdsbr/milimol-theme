<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;

class BlockTrainingHeader extends Blockable
{
    protected $block_name = 'block_training_header';

    protected $block_title = 'Header for trainings';

    protected $block_category = 'headers';

    protected $block_icon = 'cover-image';

    protected $block_keywords = ['header', 'image', 'training'];

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

        $context['post'] = $timber_post;
        $context['post_fields'] = get_fields($context['post']->ID);

        // Title
        if ( ! empty($context['fields']['use_post_title'])
            && $context['fields']['use_post_title'] == true
        ) {
            $context['getTitle'] = $context['post']->post_title ?? '';
        } else {
            $context['getTitle'] = $context['fields']['title'] ?? '';
        }

        // Text
        if ( ! empty($context['fields']['use_excerpt_or_custom_text'])
            && $context['fields']['use_excerpt_or_custom_text'] == true
        ) {
            $context['getText'] = $context['post']->post_excerpt ?? '';
        } else {
            $context['getText'] = $context['fields']['text'] ?? '';
        }

        Timber::render('blocks/headers/training-header.twig', $context);
    }
}
