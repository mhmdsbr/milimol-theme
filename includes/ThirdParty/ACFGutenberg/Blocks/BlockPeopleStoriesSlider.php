<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockPeopleStoriesSlider extends Blockable
{
    protected $block_name = 'block_people_stories_sliders';

    protected $block_title = 'People Stories Sliders';

    protected $block_category = 'slides';

    protected $block_icon = 'slides';

    protected $block_keywords = ['people', 'stories' , 'slider'];

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
        $context['block']      = $block;
        $context['fields']     = get_fields();
        $context['is_preview'] = $is_preview;
        $context['posts'] = Timber::get_posts([
            'post_type' => 'people_story',
            'posts_per_page' => 6,
            'post_status' => 'publish'
        ]);
        if (isset($context['posts']) && is_array($context['posts']) && count($context['posts']) > 0) {
            Timber::render('blocks/sliders/people-stories-slider.twig', $context);
        }
    }
}
