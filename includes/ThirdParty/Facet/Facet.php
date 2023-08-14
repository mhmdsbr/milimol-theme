<?php
/**
 * Facet helper to add facets to source-files for version control
 */

namespace EXP\ThirdParty\Facet;

class Facet
{

    public function __construct()
    {
        add_filter( 'facetwp_facets', [&$this, 'loadFacetsFromJSON']);
    }

    public function loadFacetsFromJSON($facets)
    {
        $imported_facets = json_decode(file_get_contents(get_template_directory() . '/facetwp/facets.json'), true);

        if(!isset($imported_facets['facets'])) {
            return $facets;
        }

        foreach($imported_facets['facets'] as $single_facet) {
            $facets[] = $single_facet;
        }

        return $facets;
    }
}
