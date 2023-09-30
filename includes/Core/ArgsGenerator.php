<?php
/**
 * Wp query arguments generator Class

 */
namespace EXP\Core;


class ArgsGenerator
{
    private string $postTypes = 'post';
    private int $postsPerPage = -1;
    private array $taxQuery = [];
    private array $metaQuery = [];
    public function __construct($postTypes, $postsPerPage)
    {
        $this->postTypes = $postTypes;
        $this->postsPerPage = $postsPerPage;
    }

    public function add_meta_query($key, $value, $compare, $type = null): void
    {
        $metaQueryArray = [];
        $metaQueryArray['key'] = $key;
        $metaQueryArray['value'] = $value;
        $metaQueryArray['compare'] = $compare;
        if ($type !== null) {
            $metaQueryArray['type'] = $type;
        }
        $this->metaQuery[] = [$metaQueryArray];
    }

    public function add_meta_query_external_array($args): void
    {
        $this->metaQuery = [$args];
    }
    public function add_tax_query($taxonomy, $field, $terms): void
    {
        $taxQueryArray = [];
        $taxQueryArray['taxonomy'] = $taxonomy;
        $taxQueryArray['field'] = $field;
        $taxQueryArray['terms'] = $terms;
        $this->taxQuery = [$taxQueryArray];
    }

    public function generate_arguments(): array
    {

        $finalArgs = [];
        $finalArgs['post_type'] = $this->postTypes;
        $finalArgs['posts_per_page'] = $this->postsPerPage;
        $finalArgs['tax_query'] = $this->taxQuery;
        $finalArgs['meta_query'] = $this->metaQuery;

        return $finalArgs;

    }

    public function clear_meta_query(): void {
        $this->metaQuery = [];
    }

}

