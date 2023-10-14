<?php
/**
 * Wp query arguments generator Class

 */
namespace EXP\Core;


class ArgsGenerator
{
    private string $postType = 'post';
    private int $postsPerPage = -1;
    private array $taxQuery = [];
    private array $metaQuery = [];
    private int $paged = 1;
    public function __construct($postType, $postsPerPage)
    {
        $this->postType = $postType;
        $this->postsPerPage = $postsPerPage;
    }

    public function get_tax_query(): array
    {
        return $this->taxQuery;
    }
    public function get_meta_query(): array
    {
        return $this->metaQuery;
    }
    public function add_meta_query($key, $value, $compare, $type = null): void
    {
        $metaQueryArray = [];
        $metaQueryArray['key'] = $key;
        if(is_array($value)) {
            $sanitize_value = [];
            foreach ($value as $item) {
                $sanitize_value[] = sanitize_text_field($item);
            }
            $metaQueryArray['value'] = $sanitize_value;
        } else {
            $metaQueryArray['value'] = sanitize_text_field($value);
        }
        $metaQueryArray['compare'] = $compare;
        if ($type !== null) {
            $metaQueryArray['type'] = $type;
        }
        $this->metaQuery[] = [$metaQueryArray];
    }

    public function add_tax_query($taxonomy, $field, $terms): void
    {
        $taxQueryArray = [];
        $taxQueryArray['taxonomy'] = $taxonomy;
        $taxQueryArray['field'] = $field;
        $taxQueryArray['terms'] = absint($terms);

        $this->taxQuery = [$taxQueryArray];
    }

    public function generate_arguments(): array
    {

        $finalArgs = [];
        $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
        $finalArgs['paged'] = absint($paged);
        $finalArgs['post_type'] = $this->postType;
        $finalArgs['posts_per_page'] = $this->postsPerPage;
        $finalArgs['tax_query'] = $this->taxQuery;
        $finalArgs['meta_query'] = $this->metaQuery;

        return $finalArgs;

    }

    public function clear_meta_query(): void {
        $this->metaQuery = [];
    }

    public function reset($post_type, $posts_per_page): void {

        $this->postType = $post_type;
        $this->postsPerPage = $posts_per_page;

    }
}

