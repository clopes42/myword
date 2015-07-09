<?php
require_once realpath(__DIR__ . '/includes/class/Singleton.php');
require_once realpath(__DIR__ . '/includes/helpers.php');
require_once realpath(__DIR__ . '/includes/options.php');

/**
 * Webqam singleton.
 *
 * @author Olivier Barou <obarou@webqam.fr>
 */
class Webqam extends Singleton {

    const PACKAGE_VERSION = '0.0.1';

    /**
     * @var int
     */
    protected $cacheVersion;

    /**
     * Constructor.
     */
    protected function __construct() {

        $this->cacheVersion = LOCAL_WORK || IS_PREPRODUCTION ? time() : self::PACKAGE_VERSION;
        $this->tplDir = get_template_directory_uri();

    }

    /**
     * @return Webqam
     *
     * Overrided to get autocompletion in IDE, nothing else to do here
     */
    public static function getInstance() {
        return parent::getInstance();
    }

    /**
     * Initialization.
     */
    public function init() {

        load_theme_textdomain( 'webqam', get_template_directory() . '/languages' );

        $this->actions();
        $this->filters();
        $this->menus();
        $this->images();
        $this->defines();
        $this->singleTemplate();
        $this->initCustomizations();
    }

    /**
     * Add the custom field for the theme
     */
    protected function initCustomizations() {

        require_once realpath(__DIR__ . '/includes/class/Webqam_customize.php');
        // Setup the Theme Customizer settings and controls...
        add_action( 'customize_register' , array( 'Webqam_Customize' , 'register' ) );

    }

    /**
     * @return $this
     */
    protected function actions() {

        if (!is_admin()) {
            add_action('wp_enqueue_scripts', array($this, 'loadStyles'));
            add_action('wp_enqueue_scripts', array($this, 'loadScripts'));
        }

        //  Remove Wordpress meta informations from header
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        //  Remove extra feed links from header
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);

        return $this;

    }

    protected function filters() {

        /**
         * Adds "start_in" argument.
         *
         * only submenus of this id will be displayed.
         */
        add_filter("wp_nav_menu_objects", function($sortedMenuItems, $args) {

            if(!isset($args->start_in))
                return $sortedMenuItems;

            $objectByitems = array();

            // In parent mode, start at current parent menu item
            if ($args->start_in == "parent") {
                foreach( $sortedMenuItems as $item ) {

                    $objectByitems[$item->ID] = $item->object_id;

                    // If it's curent item
                    if ($item->current)
                        $args->start_in =  $item->menu_item_parent;

                }

                // If there is no "current"
                if ($args->start_in == "parent")
                    return null;

                $args->start_in = $objectByitems[$args->start_in];
            }


            $menuItemParents = array();
            foreach( $sortedMenuItems as $key => $item ) {
                // init menu_item_parents
                if( $item->object_id == (int)$args->start_in )
                    $menuItemParents[] = $item->ID;

                if( in_array($item->menu_item_parent, $menuItemParents) ) {
                    // part of sub-tree: keep!
                    $menuItemParents[] = $item->ID;
                } else {
                    // not part of sub-tree: away with it!
                    unset($sortedMenuItems[$key]);
                }
            }

            return $sortedMenuItems;

        },10,2);


        // These 2 hooks removes domain on images src when they are uploaded/added to an article.
        // This makes transfers/production/domain changes a lot easier.
        add_filter('wp_handle_upload', function($file){

            // removes absolute prefix from URL
            $file["url"] = str_replace(get_bloginfo('url'), "", $file["url"]);

            return $file;
        });
        add_filter('image_send_to_editor', function($html){

            // removes absolute prefix from image src and link
            $html = str_replace(get_bloginfo('url'), "", $html);

            return $html;
        });

    }

    /**
     * Register basic menus.
     *
     * @return $this
     */
    protected function menus() {
        add_theme_support('menus');
        register_nav_menu('main-nav', 'Navigation principale');
        register_nav_menu('footer-nav', 'Footer');

        return $this;
    }

    /**
     * Specifies thumbnail sizes.
     *
     * @return $this
     */
    protected function images() {
        //  Enable thumbnails
        add_theme_support('post-thumbnails');

        //  Specify image formats
        // add_image_size("format", 720, 250);

        return $this;

    }

    /**
     * Define here all constants you need.
     *
     * @return $this
     */
    protected function defines() {

        // Define directory for single page
        defined('SINGLE_PATH') || define('SINGLE_PATH', TEMPLATEPATH . '/single-templates');

        return $this;
    }

    /**
     * Define directory for single page
     *
     * @return void
     */
    protected function singleTemplate() {

        add_action( 'single_template', function($single_template) {
            global $post;

            if(file_exists(SINGLE_PATH . '/single-' . $post->post_type . '.php'))
                $single_template = SINGLE_PATH . '/single-' . $post->post_type . '.php';

            return $single_template;

        } );

    }

    /**
     * Register and enqueue scripts.
     *
     * @return $this
     */
    public function loadScripts() {
        //  Register
        wp_register_script('modernizr', "$this->tplDir/js/vendor/modernizr-2.8.3.min.js", array(), null);
        wp_register_script('respond', "$this->tplDir/js/vendor/respond.min.js", array(), null);
        wp_register_script('plugins', "$this->tplDir/js/min/plugins.min.js", array(), $this->cacheVersion, true);
        wp_register_script('picasso', "$this->tplDir/js/picasso.js", array("jquery"), $this->cacheVersion, true);
        wp_register_script('smoothwheel', "$this->tplDir/js/jQuery.scrollSpeed.js", array("jquery"), $this->cacheVersion, true);
        wp_register_script('scripts', "$this->tplDir/js/scripts.js", array("jquery"), $this->cacheVersion, true);

        wp_deregister_script('jquery');

        if (IS_DEVELOPMENT) {
            // Register scripts for Developpement mode
            wp_register_script('jquery', "$this->tplDir/js/vendor/jquery-1.11.2.min.js", array(), null, true);

        } else {
            //  Register script for Production mode
            wp_register_script(
                'jquery',
                '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',
                array(),
                null,
                true
            );
        }

        //  Enqueue
        wp_enqueue_script('jquery');
        wp_enqueue_script('modernizr');
        wp_enqueue_script('respond');
        wp_enqueue_script('picasso');
        wp_enqueue_script('smoothwheel');
        wp_enqueue_script('scripts');

        return $this;

    }

    /**
     * Register and enqueue styles.
     *
     * @return $this
     */
    public function loadStyles() {

        //  Register
        wp_register_style('main', "$this->tplDir/css/front.css", array(), $this->cacheVersion);

        //  Enqueue
        wp_enqueue_style('main');

        return $this;

    }

    /**
     * Return a template with the given vars previously declared.
     *
     * @param string $template
     * @param array $vars
     * @return string
     */
    public function getTemplatePartWithVars($template, $vars = array()) {

        if (!empty($vars))
            extract($vars);

        ob_start();
        include(locate_template($template));
        return ob_get_clean();
    }

}

Webqam::getInstance()->init();