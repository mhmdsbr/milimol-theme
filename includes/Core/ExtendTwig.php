<?php

namespace EXP\Core;

use EXP\Core\TwigFunctions\TwigFunctions;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\TwigTest;
// Jalali date
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

/**
 * Timber/Twig extend functions
 */
class ExtendTwig
{
    public array $twig_functions = [];

    public function __construct()
    {
        add_filter('timber/twig', array($this, 'add_to_twig'));
    }

    public function add_to_twig($twig): Environment
    {
        $default_functions = class_exists(TwigFunctions::class) ? TwigFunctions::getFunctions() : [];
        $this->twig_functions = array_merge($default_functions, $this->twig_functions);

        foreach ($this->get_twig_functions() as $function => $callback) {
            $twig->addFunction(new TwigFunction($function, $callback));
        }

        $twig->addFunction(new TwigFunction('fetch_svg', 'fetch_svg'));
        $twig->addFunction(new TwigFunction('check_value', [$this, 'check_value']));
        $twig->addFunction(new TwigFunction('get_link', [$this, 'getPostPermalink']));
        $twig->addFunction(new TwigFunction('anchor_block', array($this, 'anchor_block')));
        $twig->addFunction(new TwigFunction('background_color', array($this, 'generateBackgroundColorClass')));
        $twig->addFunction(new TwigFunction('get_acf_fields', array($this, 'getAcfFields')));
        $twig->addFunction(new TwigFunction('get_thumbnail', array($this, 'getThumbnail')));
        $twig->addTest(new TwigTest('array', [&$this, 'is_array']));
        $twig->addFunction(new TwigFunction('exp_mobile', array($this, 'exp_is_mobile')));
        $twig->addFunction(new TwigFunction('get_value', array($this, 'check_get')));
        $twig->addFunction(new TwigFunction('is_home', array($this, 'is_home')));
        $twig->addFunction(new TwigFunction('jalali_date', array($this, 'get_jalali_date')));
        $twig->addFunction(new TwigFunction('expiry_date', array($this, 'get_jalali_expiry_date')));
        $twig->addFunction(new TwigFunction('english_numbers', array($this, 'get_english_to_persian')));


        return $twig;
    }

    private function get_twig_functions(): array
    {
        return array_map(function ($callback) {
            return [new $callback[0](), $callback[1]];
        }, $this->twig_functions);
    }

    public function check_value($input, $element, $class): string
    {
        if (!empty($input) && !empty($class)) {
            return '<' . $element . ' class="' . $class . '">' . $input . '</' . $element . '>';
        }

        if (!empty($input) && empty($class)) {
            return '<' . $element . '>' . $input . '</' . $element . '>';
        }

        return '';
    }

    public function getPostPermalink ($id): string
    {
        return get_permalink($id);
    }

    public function anchor_block($label): string
    {
        if (!is_array($label) || empty($label)) {
            return '';
        }

        if (!$label[0]['is_anchor_option_enabled'] || empty($label[0]['anchor_label'])) {
            return '';
        }

        $preg_replace = preg_replace('/[?|.|!]?/', '', $label[0]['anchor_label']);
        $stripped_label = strtolower(strip_tags(str_replace(" ", "-", $preg_replace)));

        return ' id="' . $stripped_label . '" data-anchor-name="' . $label[0]['anchor_label'] . '" data-anchor-active="true"';
    }

    public function generateBackgroundColorClass($backgroundColor): string
    {
        if (!is_array($backgroundColor) || empty($backgroundColor)) {
            return 'bg-default';
        }

        return 'bg-' . $backgroundColor[0]['background_color'];
    }

    public function getAcfFields($id): array
    {
        $fields = [];
        if (is_array(get_fields($id))) {
            $fields = get_fields($id);
        }
        return $fields;
    }

    public function getThumbnail($ID): string
    {
        $thumbnail = '';
        if(get_the_post_thumbnail_url($ID)) {
            $thumbnail = get_the_post_thumbnail_url($ID);
        }
        return $thumbnail;
    }

    public function is_array($value): bool
    {
        if (is_array($value) && count($value) > 0) {
            return true;
        }
        return false;
    }

    public function exp_is_mobile()
    {
        return wp_is_mobile();
    }

    public function check_get($getVar)
    {
        if(isset($_GET[$getVar]) && !empty($_GET[$getVar])) {
            return $_GET[$getVar];
        }
    }

    public function is_home( )
    {
        return is_front_page();
    }

function get_jalali_date(): string
{
    return Jalalian::now()->format('Y-m-d');
}

// Calculate Jalali expiry date based on published date and ACF field
    function get_jalali_expiry_date($publishedDate, $expiryDuration)
    {
        $now = Jalalian::now()->format('Y-m-d');
        $carbonPublishedDate = Carbon::parse($publishedDate);
        $diffPubNow = $carbonPublishedDate->diff($now)->format("%d");
        $remainingDays = $expiryDuration - $diffPubNow;

        return $remainingDays;

    }

    // Add a filter to convert Persian digits to English
    function get_english_to_persian($number): array|string
    {
        $englishNumbers = \Morilog\Jalali\CalendarUtils::convertNumbers($number);

        return $englishNumbers;
    }

}

