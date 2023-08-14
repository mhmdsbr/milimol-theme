<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockUpcomingTrainingsPrograms extends Blockable
{
    protected $block_name = 'block_upcoming_trainings_programs';

    protected $block_title = 'Upcoming Trainings Programs';

    protected $block_category = 'layout';

    protected $block_icon = 'align-wide';

    protected $block_keywords = ['training', 'upcoming', 'programs', 'event'];

    /**
     * Callback method that displays the block
     *
     * @param array   $block
     * @param string  $content
     * @param boolean $is_preview
     *
     * @return void
     */
    public function renderCallback(array $block, string $content = '', bool $is_preview = true): void
    {
        $context['block']              = $block;
        $context['fields']             = get_fields();
        $context['is_preview']         = $is_preview;
        $context['upcoming_trainings'] = $this->getUpcomingTrainings();

        if (!isset($context['upcoming_trainings'])) {
            return;
        }
        if (!is_countable($context['upcoming_trainings'])) {
            return;
        }
        if (!count($context['upcoming_trainings']) > 0) {
            return;
        }

        Timber::render('blocks/layout/upcoming-training-programs.twig', $context);

    }

    public function getUpcomingTrainings()
    {
        $currentDate = date('j M Y');

        $args = [
            'post_type'        => 'training',
            'posts_per_page'   => 3,
            'post_status'      => 'publish',
            "meta_query" => [
                "sort_0" => [
                    "key" => "training_meta_date",
                    "compare" => ">",
                    "type" => "DATE",
                    "value" => date("Y-m-d"),
                ],
            ],
            'meta_key'         => 'training_meta_date',
            'no_found_rows'    => true,
            'orderby'          => 'meta_value',
            'order'            => 'DESC',
            'suppress_filters' => false,
        ];

        return get_posts($args);
    }
}
