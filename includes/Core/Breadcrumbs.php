<?php
namespace EXP\Core;
use Twig\TwigFunction;

class Breadcrumbs
{
    public array $twig_functions = [];

    public function __construct()
    {
        add_filter('timber/twig', array($this, 'add_to_twig'));
    }

    public function add_to_twig($twig)
    {
        $default_functions = class_exists(TwigFunctions::class) ? TwigFunctions::getFunctions() : [];
        $this->twig_functions = array_merge($default_functions, $this->twig_functions);

        foreach ($this->get_twig_functions() as $function => $callback) {
            $twig->addFunction(new TwigFunction($function, $callback));
        }
        $twig->addFunction(new TwigFunction('custom_breadcrumbs', array($this, 'custom_breadcrumbs')));

        return $twig;
    }

    private function get_twig_functions(): array
    {
        return array_map(function ($callback) {
            return [new $callback[0](), $callback[1]];
        }, $this->twig_functions);
    }

    /**
     * Breadcrumbs function stolen from:
     * https://github.com/BenSibley/ignite/blob/master/inc/breadcrumbs.php
     *
     * @param  array  $args
     * @return string|void
     */
    public function custom_breadcrumbs($args = array())
    {
        if (is_front_page()) {
            return;
        }

        global $post;

        $defaults = array(
            'breadcrumbs_id'      => 'breadcrumbs',
            'breadcrumbs_classes' => 'breadcrumb-trail breadcrumbs',
            'home_title'          => esc_html__('Home', 'expedition'),
            'separator'           => '<span class="separator"><svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m1 8.906 2.94-2.94a1.5 1.5 0 0 0 0-2.12L1 .906" stroke="#728182" stroke-width="1.5"/></svg></span>',
            'back_icon'           => '<span class="back-separator"><svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 1 2.06 3.94a1.5 1.5 0 0 0 0 2.12L5 9" stroke="#009CEB" stroke-width="1.5"/></svg></span>',
        );
        $args = wp_parse_args($args, $defaults);

        // Open the breadcrumbs
        $html = '<ul id="' . esc_attr($args['breadcrumbs_id']) . '" class="' . esc_attr($args['breadcrumbs_classes']) . '">';
        // Add Homepage link & separator (always present)
        $html .= '<li class="item-home">
            <a class="bread-link bread-home"
                href="' . get_home_url() . '"
                title="' . esc_attr($args['home_title']) . '">' . esc_html($args['home_title']) . '</a>' . $args['separator'] . '</li>';

        // Post display .. with parents, categories etc.
        if (is_singular() && property_exists($post, 'ID')) {
            $show_categories = true;

            // show direct parent if the post is an attachment
            if (is_attachment()) {
                $parent_id        = $post->post_parent;
                $parent_title     = get_the_title($parent_id);
                $parent_permalink = esc_url(get_permalink($parent_id));
                $html .= '<li class="item-parent">
                <a class="bread-parent"
                    href="' . esc_url($parent_permalink) . '"
                    title="' . esc_attr($parent_title) . '">' . wp_strip_all_tags($parent_title) . '</a></li>';
                $show_categories = false;
            }

            $post_type = get_post_type($post->ID);
            if (in_array($post_type, array( 'trainings' )) && ! is_attachment()) {
                $new_post_type = __('Academy','expedition');
                $base_url = get_field('academy_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
                $show_categories = false;
            }

            if (in_array($post_type, array( 'industry' )) && ! is_attachment()) {
                $new_post_type = __('Industries','expedition');
                $base_url = get_field('industries_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
                $show_categories = false;
            }

            if (in_array($post_type, array( 'service' )) && ! is_attachment()) {
                $new_post_type = __('Services','expedition');
                $base_url = get_field('services_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
                $show_categories = false;
            }

            if (in_array($post_type, array( 'insight' )) && ! is_attachment()) {
                $new_post_type = __('Insights','expedition');
                $base_url = get_field('insights_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
                $show_categories = false;
            }

            if (in_array($post_type, array( 'case' )) && ! is_attachment()) {
                $new_post_type = __('Cases','expedition');
                $base_url = get_field('cases_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
                $show_categories = false;
            }

            if (in_array($post_type, array( 'people_story' )) && ! is_attachment()) {
                $new_post_type = __('Stories','expedition');
                $base_url = get_field('people_stories_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
                $show_categories = false;
            }

            if (in_array($post_type, array( 'press_release' )) && ! is_attachment()) {
                $new_post_type = __('Press releases','expedition');
                $base_url = get_field('press_releases_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
                $show_categories = false;
            }

            if (in_array($post_type, array( 'certi_industry' )) && ! is_attachment()) {
                $new_post_type = __('Certification industries','expedition');
                $base_url = get_field('certification_industries_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
                $show_categories = false;
            }

            if (in_array($post_type, array( 'certi_program' )) && ! is_attachment()) {
                $new_post_type = __('Certification programs','expedition');
                $base_url = get_field('certification_programs_base_link', 'option');
                $html .= $this->createOverviewPageLink($post_type, $new_post_type, $base_url, $args['separator'], $args['back_icon']);
               $show_categories = false;
            }

            // show all parents if the post is not an attachment
            if (! is_attachment() && $post->post_parent) {
                $parents = get_post_ancestors($post->ID);
                $parents = array_reverse($parents);

                // only show last 2 parent levels if the tree is larger than 2
                if (count($parents) > 2) {
                    $html .= '<li class="item-parent">' . $args['separator'] . '</li>';
                    $parents = array_slice($parents, -2);
                }

                foreach ($parents as $parent) {
                    $title = wp_strip_all_tags(get_the_title($parent));

                    if (strtolower($title) == 'product' || strtolower($title) == 'products') {
                        $title = 'Courses';
                    }

                    $html .= '<li class="item-parent item-parent-' . esc_attr($parent) . '">
                        <a class="bread-parent bread-parent-' . esc_attr($parent) . '"
                            href="' . esc_url(get_permalink($parent)) . '"
                            title="' . esc_attr(get_the_title($parent)) . '">' . $title . '</a>' . $args['separator'] . '</li>';
                }

                $show_categories = false;
            }

            // show available parent categories (if post type and other parents are not displayed)
            $category = get_the_category($post->ID);
            if ($category && $show_categories) {
                $category_values = array_values($category);
                $last_category = end($category_values);
                $cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                $cat_parents = explode(',', $cat_parents);

                foreach ($cat_parents as $parent) {
                    $html .= '<li class="item-cat">' . wp_kses($parent, wp_kses_allowed_html('a')) . '</li>';
                }
            }

            // Show the post title
            if (get_the_title()) {
                $title = wp_strip_all_tags(get_the_title());

                if (strtolower($title) == 'product' || strtolower($title) == 'products') {
                    $title = 'courses';
                }

                $html .= '<li class="item-current item-' . $post->ID . '">
                    <span class="bread-current bread-' . $post->ID . '"
                        title="' . esc_attr(get_the_title()) . '">' . $title . '</span></li>';
            } else {
                $title = wp_strip_all_tags($post->post_title);

                if (strtolower($title) == 'product' || strtolower($title) == 'products') {
                    $title = 'courses';
                }

                $html .= '<li class="item-current item-'.$post->ID.'">
                    <span class="bread-current bread-' . $post->ID . '"
                        title="' . $post->post_title . '">'. $title .'</span></li>';
            }
        } elseif (is_category()) {
            $parent = get_queried_object()->category_parent;

            if ($parent !== 0) {
                $parent_category = get_category($parent);
                $category_link   = get_category_link($parent);

                $title = esc_html($parent_category->name);

                if (strtolower($title) == 'product' || strtolower($title) == 'products') {
                    $title = 'Courses';
                }

                $html .= '<li class="item-parent item-parent-' . esc_attr($parent_category->slug) . '">
                    <a class="bread-parent bread-parent-' . esc_attr($parent_category->slug) . '"
                        href="' . esc_url($category_link) . '"
                        title="' . esc_attr($parent_category->name) . '">' . $title . '</a></li>';
            }

            $cat = single_cat_title('', false);

            if (strtolower($cat) == 'product' || strtolower($cat) == 'products') {
                $cat = 'Courses';
            }

            $html .= '<li class="item-current item-cat">
                    <span class="bread-current bread-cat"
                        title="'. esc_html(single_cat_title('', false)).'">' . $cat . '</span></li>';
        } elseif (is_tag()) {
            $title = single_tag_title('', false);

            if (strtolower($title) == 'product' || strtolower($title) == 'products') {
                $title = 'Courses';
            }

            $html .= '<li class="item-current item-tag"><span class="bread-current bread-tag">' . $title . '</span></li>';
        } elseif (is_author()) {
            $html .= '<li class="item-current item-author"><span class="bread-current bread-author">' . get_queried_object()->display_name . '</span></li>';
        } elseif (is_day()) {
            $html .= '<li class="item-current item-day"><span class="bread-current bread-day">' . get_the_date() . '</span></li>';
        } elseif (is_month()) {
            $html .= '<li class="item-current item-month"><span class="bread-current bread-month">' . get_the_date('F Y') . '</span></li>';
        } elseif (is_year()) {
            $html .= '<li class="item-current item-year"><span class="bread-current bread-year">' . get_the_date('Y') . '</span></li>';
        } elseif (is_archive()) {
            $custom_tax_name = get_queried_object()->name;

            if (strtolower($custom_tax_name) == 'product' || strtolower($custom_tax_name) == 'products') {
                $custom_tax_name = 'Courses';
            }

            $html .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html(ucfirst($custom_tax_name)) . '</span></li>';
        } elseif (is_search()) {
            $html .= '<li class="item-current item-search"><span class="bread-current bread-search">'. esc_html(__("Search results for:", "ron")) . ' ' . get_search_query() . '</span></li>';
        } elseif (is_404()) {
            $html .= '<li class="item-current">' . esc_html__('Error 404', 'ron') . '</li>';
        } elseif (is_home()) {
            $html .= '<li>' . esc_html(ucfirst(get_the_title(get_option('page_for_posts')))) . '</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    public function createOverviewPageLink ($post_type, $new_post_type, $base_url, $separator = '', $back_icon = '')
    {
        return '<li class="item-parent item-custom-post-type-' . esc_attr($post_type) . '">
                    <a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '"
                        href="' . $base_url . '"
                        title="' . esc_attr($new_post_type) . '">'. $back_icon . wp_strip_all_tags( ucfirst($new_post_type) ) . '</a>' . $separator . '</li>';


    }
}
