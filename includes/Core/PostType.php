<?php
/**
 * Some general WordPress function calls
 */
namespace EXP\Core;

class PostType
{
    public function __construct()
    {
        /** General setup methods */
        add_action('init', [&$this, 'create_custom_post_types']);
    }

    /**
     * General setup methods for multiple things all WordPress related
     *
     * @return void
     */
    public function create_custom_post_types() : void
    {
        add_theme_support('post-thumbnails');

        $supports = array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes');

        $this->registerPostType(
            'industry',
            'شرکت ها',
            'شرکت',
            'industry',
            true,
            'industry',
            true,
            false,
            [],
            true,
            'dashicons-building',
            true,
            $supports
        );

        $this->registerPostType(
            'insight',
            'درخواست های خرید',
            'درخواست خرید',
            'insight',
            true,
            'insight',
            true,
            false,
            [],
            true,
            'dashicons-admin-post',
            true,
            $supports
        );

        $supports_faq = array('title', 'revisions', 'page-attributes');
        $this->registerPostType(
            'faq',
            'سوالات پر تکرار ',
            'سوال پر تکرار ',
            'faq',
            false,
            'faq',
            true,
            false,
            [],
            true,
            'dashicons-editor-help',
            false,
            $supports_faq
        );

        $this->registerTaxonomy(
            'Categories',
            'Category',
            'faq_category',
            ['faq'],
            'faq-category',
        );

        $supports_process = array('title', 'revisions', 'page-attributes');
        $this->registerPostType(
            'process',
            'فرآیند ها',
            'فرآیند',
            'process',
            false,
            'process',
            true,
            false,
            [],
            true,
            'dashicons-admin-generic',
            false,
            $supports_process,
        );

        $this->registerPostType(
            'service',
            'Services',
            'Service',
            'service',
            true,
            'service',
            true,
            false,
            [],
            true,
            'dashicons-admin-generic',
            true,
            $supports
        );

        $this->registerTaxonomy(
            'Service types',
            'Service type',
            'service_type',
            ['service'],
            'service-type',
        );

        $supports_cases = array('title', 'thumbnail', 'revisions', 'page-attributes');
        $this->registerPostType(
            'case',
            'Cases',
            'Case',
            'case',
            true,
            'case',
            true,
            false,
            [],
            true,
            'dashicons-portfolio',
            true,
            $supports_cases
        );

        $supports_banners = array('title', 'thumbnail', 'revisions', 'page-attributes');
        $this->registerPostType(
            'banner',
            'Banners',
            'Banner',
            'banner',
            false,
            'banner',
            true,
            false,
            [],
            true,
            'dashicons-images-alt',
            true,
            $supports_banners
        );

        $supports_usp = array('title', 'revisions', 'page-attributes');
        $this->registerPostType(
            'usp',
            'USP\'s',
            'USP',
            'usp',
            false,
            'usp',
            true,
            false,
            [],
            true,
            'dashicons-awards',
            true,
            $supports_usp,
    );

        $supports_contact = array('title', 'revisions', 'page-attributes');
        $this->registerPostType(
            'contact',
            'Contacts',
            'Contact',
            'contact',
            false,
            'contact',
            true,
            false,
            [],
            true,
            'dashicons-businessperson',
            false,
            $supports_contact
        );

        $this->registerPostType(
            'people_story',
            'People Stories',
            'People Story',
            'people_story',
            false,
            'people_story',
            true,
            false,
            [],
            true,
            'dashicons-admin-comments',
            true,
            $supports
        );


        $this->registerPostType(
            'training',
            'Trainings',
            'Training',
            'training',
            false,
            'training',
            true,
            false,
            [],
            true,
            'dashicons-welcome-learn-more',
            true,
            $supports
        );

        $this->registerTaxonomy(
            'Regions',
            'Region',
            'region',
            ['training', 'certi_program'],
            'region',
        );

        $this->registerTaxonomy(
            'Training types',
            'Training type',
            'trainings_type',
            ['training'],
            'trainings-type',
        );

        $this->registerPostType(
            'press_release',
            'Press Releases',
            'Press Release',
            'press_release',
            false,
            'press_release',
            true,
            false,
            [],
            true,
            'dashicons-admin-comments',
            true,
            $supports
        );

        $this->registerPostType(
            'certi_service',
            'Certification Services',
            'Certification Service',
            'certi_service',
            false,
            'certi_service',
            true,
            false,
            [],
            true,
            'dashicons-admin-generic',
            true,
            $supports
        );

        $this->registerPostType(
            'certi_industry',
            'Certification Industries',
            'Certification Industry',
            'certi_industry',
            false,
            'certi_industry',
            true,
            false,
            [],
            true,
            'dashicons-building',
            true,
            $supports
        );

        $this->registerPostType(
            'certi_program',
            'Certification Programs',
            'Certification Program',
            'certi_program',
            false,
            'certi_program',
            true,
            false,
            [],
            true,
            'dashicons-awards',
            true,
            $supports
        );

        $supports_office = array('title');
        $this->registerPostType(
            'office',
            'Offices',
            'Office',
            'office',
            false,
            'office',
            true,
            false,
            [],
            true,
            'dashicons-building',
            false,
            $supports_office
        );

        $this->registerTaxonomy(
            'Office Regions',
            'Office Region',
            'office_region',
            ['office'],
            'office_region',
        );

        $this->registerTaxonomy(
            'شماره هویت',
            ' شماره هویت',
            'product_cas_no',
            ['product'],
            'product_cas_no',
        );
    }

    protected function registerPostType (string $reg_name, string $plural_name, string $singular_name, string $slug, bool $front, string $show_in_menu,  bool $public, bool $has_archive, array $taxonomies, bool $hierarchical, string $dashicon, bool $rest, array $supports) : void
    {
        $labels = array(
            'name'                  => __($plural_name, 'expedition'),
            'singular_name'         => __($singular_name, 'expedition'),
            'menu_name'             => __($plural_name, 'expedition'),
            'name_admin_bar'        => __($singular_name, 'expedition'),
            'attributes'            => __(ucfirst($singular_name) .' attributes', 'expedition'),
            'parent_item_colon'     => __('Parent ' . $singular_name . ':', 'expedition'),
            'all_items'             => __(' همه ' . $plural_name, 'expedition'),
            'add_new_item'          => __('افزودن جدید ' . $singular_name, 'expedition'),
            'add_new'               => __('افزودن جدید ', 'expedition'),
            'new_item'              => __('جدید ' . $singular_name, 'expedition'),
            'edit_item'             => __('ویرایش ' . $singular_name, 'expedition'),
            'update_item'           => __('به روز رسانی ' . $singular_name, 'expedition'),
            'view_item'             => __('نمایش ' . $singular_name, 'expedition'),
            'view_items'            => __('نمایش ' . $plural_name, 'expedition'),
            'search_items'          => __('جست و جو ' . $plural_name, 'expedition'),
            'not_found'             => __('یافت نشد ', 'expedition'),
            'not_found_in_trash'    => __('در سطل زباله یافت نشد ', 'expedition'),
            'featured_image'        => __('تصویر برجسته ', 'expedition'),
            'set_featured_image'    => __('افزودن تصویر برجسته ', 'expedition'),
            'remove_featured_image' => __('پاک کردن تصویر برجسته ', 'expedition'),
            'use_featured_image'    => __('استفاده به عنوان تصویر برجسته ', 'expedition'),
            'insert_into_item'      => __('وارد کردن در ' . $singular_name, 'expedition'),
            'uploaded_to_this_item' => __('بارگذاری در ' . $singular_name, 'expedition'),
            'items_list'            => __($plural_name . ' list', 'expedition'),
            'items_list_navigation' => __($plural_name . ' list navigation', 'expedition'),
            'filter_items_list'     => __('Filter ' . $plural_name .' list', 'expedition'),
        );

        register_post_type(
            $reg_name,
            array(
                'labels'            =>  $labels,
                'rewrite'           =>  array(
                    'slug'          =>  __($slug, 'expedition'),
                    'with_front'    =>  $front
                ),
                'public'            =>  $public,
                'has_archive'       =>  $has_archive,
                'taxonomies'        =>  $taxonomies,
                'hierarchical'      =>  $hierarchical,
                'menu_icon'         =>  $dashicon,
                'show_in_rest'      =>  $rest,
                'show_ui'           =>  true,
                'show_in_menu'      =>  true,
                'menu_position'     =>  5,
                'show_in_admin_bar' =>  true,
                'show_in_nav_menus' =>  true,
                'supports'          =>  $supports
            )
        );
    }

    protected function registerTaxonomy(string $label_plural, string $label_singular, string $taxonomy_name, array $post_type, $slug) : void
    {
        $labels = array(
            'name' => _x(ucfirst($label_plural), 'taxonomy general name' , 'expedition'),
            'singular_name' => _x(ucfirst($label_singular), 'taxonomy singular name' , 'expedition'),
            'search_items' =>  __('جست و جو' . $label_plural, 'expedition'),
            'all_items' => __('همه ' . $label_plural, 'expedition'),
            'parent_item' => __('آیتم اصلی ' . $label_singular, 'expedition'),
            'parent_item_colon' => __('آیتم اصلی ' . $label_singular . ':' , 'expedition'),
            'edit_item' => __('ویرایش ' . $label_singular , 'expedition'),
            'update_item' => __('به روز رسانی ' . $label_singular , 'expedition'),
            'add_new_item' => __('افزودن جدید ' . $label_singular , 'expedition'),
            'new_item_name' => __('جدید ' . $label_singular , 'expedition'),
            'menu_name' => __(ucfirst($label_plural) , 'expedition'),
        );

        register_taxonomy($taxonomy_name, $post_type, array(
            'hierarchical'      =>  true,
            'labels'            =>  $labels,
            'show_ui'           =>  true,
            'show_in_rest'      =>  true,
            'show_admin_column' =>  true,
            'query_var'         =>  true,
            'rewrite'           =>  array('slug' => $slug),
        ));
    }
}
