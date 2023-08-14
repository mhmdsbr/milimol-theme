<?php
/**
 * Login page class
 */
namespace EXP\Admin;

class Login
{
    public function __construct()
    {
        add_action('login_enqueue_scripts', [&$this, 'customLogo']);
        add_action('login_headerurl', [&$this, 'customUrl']);
        add_action('login_headertext', [&$this, 'customUrlText']);
    }

    /**
     * Modify admin logo
     */
    public function customLogo()
    {
        ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/some-logo.png');
    		    height: 50px;
    		    width: 143px;
    		    background-size: 143px 50px;
    		    background-repeat: no-repeat;
            }
        </style>
        <?php
    }

    /**
     * Modify admin url
     */
    public function customUrl()
    {
        return home_url();
    }

    /**
     * Modify admin url text
     */
    public function customUrlText()
    {
        return 'Expedition';
    }
}
