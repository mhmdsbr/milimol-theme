<?php
/**
 * Enqueue styles and scripts
 */
namespace EXP\Core;

class Enqueues
{
    /**
     * Variable to hold the manifest file contents
     *
     * @var array
     */
    protected $manifest;

    public function __construct()
    {
        $this->manifest = $this->getManifest();

        if (!empty($this->manifest)) {
            add_action('wp_enqueue_scripts', [&$this, 'enqueueStylesAndScripts']);
        }

        add_action('admin_enqueue_scripts', [&$this, 'enqueueAdminStylesAndScripts']);
    }

    /**
     * Enqueue the styles and scripts
     *
     * @return void
     */
    public function enqueueStylesAndScripts()
    {

        $styles = $this->loadAssetFromManifest('app.css');
        $scripts = $this->loadAssetFromManifest('app.js');

        wp_enqueue_style('expedition-styles', get_template_directory_uri() . '/assets/css/' . $styles, [], null);

        wp_register_script('expedition-scripts', get_template_directory_uri() . '/assets/js/'. $scripts, ['jquery'], null, true);
        wp_enqueue_script('expedition-scripts');
        wp_localize_script( 'expedition-scripts', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }

    /**
     * Fetch the manifest.json file if it is available
     *
     * @return false|array
     */
    private function getManifest()
    {
        $manifest = get_template_directory() . '/assets/manifest.json';

        if (!file_exists($manifest)) {
            return false;
        }

        return json_decode(file_get_contents($manifest), true);
    }

    /**
     * Check if the asset is in the manifest and return the filename
     *
     * @param string $file
     * @return false|string
     */
    private function loadAssetFromManifest(string $file)
    {
        if (!isset($this->manifest[$file])) {
            return false;
        }

        $paths = explode('/', $this->manifest[$file]);

        return end($paths);
    }

    public function enqueueAdminStylesAndScripts()
    {
        wp_enqueue_style('extra-expedition-admin-css', get_template_directory_uri() . '/admin-styles-scripts/admin-style.css', false);
    }
}
