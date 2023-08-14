<?php
/**
 * Helper class to initialize custom ACF Gutenberg block classes
 */
namespace EXP\ThirdParty\ACFGutenberg;

use EXP\ThirdParty\ACFGutenberg\Blocks\Block;
use EXP\ThirdParty\ACFGutenberg\Parts\Part;


class ACFGutenberg
{
    private $classes;


    public function __construct()
    {
        add_filter( 'block_categories', [&$this, 'addCustomBlockCategories'], 10, 2 );
        $this->classes = [
            ...Block::getClasses(),
            ...Part::getClasses()
        ];
    }

    /**
     * Register Advanced Custom Field blocks for Gutenberg
     *
     * @return void
     */
    public function registerBlocks(): void
    {
        if (function_exists('acf_register_block_type')) {
            foreach ($this->classes as $class)
            {
                add_action('acf/init', [$class, 'register']);
            }

        }
    }

    public function addCustomBlockCategories( $categories ): array
    {
        return array_merge(
            $categories,
            array(
                array(
                    'slug'  => 'headers',
                    'title' => __( 'Headers', 'expedition' ),
                    'icon'  => 'welcome-view-site',
                ),
                array(
                    'slug'  => 'layout',
                    'title' => __( 'Layout', 'expedition' ),
                    'icon'  => 'welcome-view-site',
                ),
                array(
                    'slug'  => 'listings',
                    'title' => __( 'Listings', 'expedition' ),
                    'icon'  => 'welcome-view-site',
                ),
                array(
                    'slug'  => 'sliders',
                    'title' => __( 'Sliders', 'expedition' ),
                    'icon'  => 'welcome-view-site',
                ),
                array(
                    'slug'  => 'facet_wp',
                    'title' => __( 'Facet WP', 'expedition' ),
                    'icon'  => 'welcome-view-site',
                ),
                array(
                    'slug'  => 'templates',
                    'title' => __( 'Templates', 'expedition' ),
                    'icon'  => 'welcome-view-site',
                ),
            )
        );
    }
}
