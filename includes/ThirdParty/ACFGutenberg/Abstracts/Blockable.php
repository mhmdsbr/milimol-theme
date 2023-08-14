<?php
namespace EXP\ThirdParty\ACFGutenberg\Abstracts;

abstract class Blockable
{
    public $disable = false;

    protected $block_name;

    protected $block_title;

    protected $block_category;

    protected $block_icon;

    protected $block_keywords = [];

    protected $block_mode = 'edit';

    protected $block_mode_toggle = true;

    protected $block_jsx = false;

    abstract public function renderCallback(array $block, string $content = '', bool $is_preview = true): void;

    public function register(): void
    {
        acf_register_block_type([
            'name' => $this->block_name,
            'title' => __($this->block_title, 'expedition'),
            'render_callback' => [&$this, 'renderCallback'],
            'category' => $this->block_category,
            'icon' => $this->block_icon,
            'keywords' => $this->block_keywords,
            'mode' => $this->block_mode,
            'supports' => [
                'align' => false,
                'mode' => $this->block_mode_toggle,
                'jsx' => $this->block_jsx
            ],
        ]);
    }

    public function getblockName()
    {
        return $this->block_name;
    }
}
