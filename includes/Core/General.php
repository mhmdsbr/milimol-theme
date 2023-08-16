<?php
/**
 * Some general WordPress function calls
 */

namespace EXP\Core;

class General
{
    public function __construct()
    {
        /** General setup methods */
        add_action('after_setup_theme', [&$this, 'generalSetup']);

        /** Custom Admin footer */
        add_filter('admin_footer_text', [&$this, 'customAdminFooterText']);

        /** Custom excerpt length */
        add_filter('excerpt_length', [&$this, 'customExcerptLength']);

        /** New excerpt more */
        add_filter('excerpt_more', [&$this, 'newExcerptMore']);

        /** Load ACF options global */
        add_filter('timber_context', [&$this, 'loadACFOptions']);

        /** Add classes to the body element */
        add_filter( 'body_class',[&$this, 'addBodyClasses'] );

        /** Helper to delete the adminbar when developing */
        if (isset($_GET['nobar'])) {
            add_filter('show_admin_bar', '__return_false');
        }

        if (is_admin() && is_user_logged_in()) {
            $this->checkActivePlugins();
        }


        // Change search query parameter
//        add_filter('init', function(){
//            global $wp;
//
//            $wp->add_query_var( '_global_search' );
//            $wp->remove_query_var( 's' );
//        } );
//
//        add_filter( 'request', function( $request ){
//            if ( isset( $_REQUEST['_global_search'] ) ){
//                $request['s'] = $_REQUEST['_global_search'];
//            }
//
//            return $request;
//        } );

        add_filter('tiny_mce_before_init', function($init_array) {
            $init_array['formats'] = json_encode([
                // add new format to formats
                'p' => [
                    'selector' => 'p',
                    'block'    => 'p',

                ],
                'intro' => [
                    'selector' => 'div',
                    'block'    => 'div',
                ],
            ], JSON_THROW_ON_ERROR);

            // remove from that array not needed formats
            $block_formats = [
                'Paragraph=p',
                'Intro=intro',
                'Heading 2=h2',
                'Heading 3=h3',
                'Heading 4=h4',
                'Heading 5=h5',
                'Heading 6=h6',
                'Preformatted=pre',
            ];
            $init_array['block_formats'] = implode(';', $block_formats);

            return $init_array;
        });
    }

    /**
     * General setup methods for multiple things all WordPress related
     *
     * @return void
     */
    public function generalSetup(): void
    {
        /** Show title tag in <head> */
        add_theme_support('title-tag');

        /** Add post thumbnail support for theme */
        add_theme_support('post-thumbnails');

        /** Register menu's */
        register_nav_menu('primary-menu', 'Primary menu');
        register_nav_menu('legal-menu', 'Legal menu');
        register_nav_menu('footer-menu-first', 'Footer menu first');
        register_nav_menu('footer-menu-second', 'Footer menu second');
        register_nav_menu('footer-menu-third', 'Footer menu third');
        register_nav_menu('footer-menu-fourth', 'Footer menu fourth');
    }

    /**
     * Customizing the Admin footer text
     *
     * @return string
     */
    public function customAdminFooterText(): string
    {
        return 'طراح: <a href="https://www.bitfactory.nl/" target="_blank" rel="noopener"> محمد صابر </a>';
    }

    /**
     * Create excerpt from content
     */
    public function customExcerptLength($length)
    {
        return 20;
    }

    /**
     * Change excerpt dots
     */
    public function newExcerptMore($more)
    {
        return '...';
    }

    /**
     * @param $context
     * @return mixed
     */
    public function loadACFOptions($context)
    {
        $context['options'] = get_fields('option');
        return $context;
    }

    /**
     * @return string
     */
    public function custom_gravity_form_local_save_path()
    {
        return ABSPATH . 'wp-content/themes/milimol-theme/gravityforms/gf-json';
    }

    /**
     * @return void
     */
    public function checkActivePlugins()
    {
        if (function_exists('is_plugin_active')) {
            if (is_plugin_active('gravityforms/gravityforms.php') && is_plugin_active('power-boost-for-gravity-forms/gravityforms-power-boost.php')) {
                add_filter('gravityforms_local_json_save_path', [&$this, 'custom_gravity_form_local_save_path']);
            }
        }
    }

    /**
     * @param $classes
     * @return array
     */
    public function addBodyClasses ($classes): array
    {
        $classes[] = "cu-theme";
        return $classes;
    }

}
