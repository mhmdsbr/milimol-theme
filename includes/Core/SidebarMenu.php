<?php
/**
 * Sidebar Menu
 */
namespace EXP\Core;

class SidebarMenu
{
    public function __construct()
    {
        add_shortcode('SIDEBARMENU-ITEMS', [&$this, 'getParentChildItems']);
        add_shortcode('SIDEBARMENU-MAIN-TITLE', [&$this, 'getMainParentTitle']);
    }

    public function getParentChildItems()
    {
        global $post;

        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);
            $parent = $ancestors[count($ancestors) - 1];
        } else {
            $parent = $post->ID;
        }

        $children = wp_list_pages("title_li=&child_of=" . $parent . "&echo=0");

        if ($children) {
            ob_start();
            ?>

            <ul class="sidebar-navigation<?php echo (!$post->post_parent ? ' top-parent' : ''); ?>">
                <?php if (!$post->post_parent) { ?>
                    <li class="page_item current_page_item page_item_mobile"><a href="<?php echo get_permalink( get_the_ID() ); ?>" title="<?php echo $post->post_title; ?>"><?php echo $post->post_title; ?></a></li>
                <?php } ?>

                <?php
                echo $children;
                ?>
            </ul>

            <?php
            return ob_get_clean();
        }
    }

    public function getMainParentTitle()
    {
        global $post;
        $ancestors = array_reverse(get_post_ancestors($post->ID), false);

        if ($ancestors) {
            $mainParentTitle = get_the_title($ancestors[0]);
            $mainParentURL = get_permalink($ancestors[0]);

            ob_start(); ?>

                <h5><?= '<span class="main-item-pre">' . __('Bekijk in', 'expedition') . '</span>'; ?> <?= $mainParentTitle; ?></h5>

            <?php return ob_get_clean();
        }
    }
}
