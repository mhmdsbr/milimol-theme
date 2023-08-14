<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockLinkedServices extends Blockable
{
    protected $block_name = 'block_linked_services';

    protected $block_title = 'Linked services';

    protected $block_category = 'listings';

    protected $block_icon = 'building';

    protected $block_keywords = ['services', 'list', 'overview', 'services'];

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
        $timber_post            = Timber::get_post();
        $context['block']       = $block;
        $context['fields']      = get_fields();
        $context['is_preview']  = $is_preview;
        $context['post_fields'] = get_fields($timber_post);

        if (
            !isset($context['post_fields']['p2p_service_industry']) ||
            !is_array($context['post_fields']['p2p_service_industry']) ||
            !is_countable($context['post_fields']['p2p_service_industry'])
        ) {
            $context['post_fields']['p2p_service_industry'] = [];
        }

        if (
            !isset($context['post_fields']['p2p_certification_service_industry']) ||
            !is_array($context['post_fields']['p2p_certification_service_industry']) ||
            !is_countable($context['post_fields']['p2p_certification_service_industry'])
        ) {
            $context['post_fields']['p2p_certification_service_industry'] = [];
        }

        if (!count($context['post_fields']['p2p_service_industry']) > 0 && !count($context['post_fields']['p2p_certification_service_industry']) > 0) {
            return;
        }

        $context['services'] = $this->getPostTerms($context['post_fields']['p2p_service_industry'], $context['post_fields']['p2p_certification_service_industry']);
        Timber::render('blocks/listings/linked-services.twig', $context);

    }

    public function getPostTerms($servicesPosts, $certificationServicesPosts): array
    {
        $services       = [];
        $active_terms   = [];
        $services_posts = [];

        foreach ($servicesPosts as $key => $post) {
            $terms         = get_the_terms($post->ID, 'service_type');
            $servicesTerms = [];

            if (!empty($terms)) {
                foreach ($terms as $term) {
                    $servicesTerm    = [
                        'slug' => $term->slug,
                        'name' => $term->name,
                    ];
                    $servicesTerms[] = $servicesTerm;
                }
            }
            $services_posts[$post->post_name]['post']  = $post;
            $services_posts[$post->post_name]['terms'] = $servicesTerms;
            
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    if (!in_array($term, $active_terms)) {
                        $active_terms[] = $term;
                    }
                }
            }
        }

        if (is_countable($certificationServicesPosts) && count($certificationServicesPosts) > 0) {
            $certificationServicesTerm    = [];
            $certificationServicesTerm = [
                'slug' => 'certification',
                'name' => 'Certification',
            ];

            foreach ($certificationServicesPosts as $key => $post) {
                $services_posts[$post->post_name]['post']  = $post;
                $services_posts[$post->post_name]['terms'] = $certificationServicesTerm;
            }

            $active_terms[] = $certificationServicesTerm;
        }

        if (!empty($services_posts)) {
            ksort($services_posts);
        }

        $services['posts']        = $services_posts;
        $services['active_terms'] = $active_terms;

        return $services;
    }
}
