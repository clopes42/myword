<?php
/*
Plugin Name: Easy Migration
Plugin URI: http://www.webqam.fr
Description: Migration plugin
Version: 1.0
Author: Webqam
Author URI: http://www.webqam.fr
*/

/**
 * Class EasyMigration.
 * If your website use some plugins which store/serialize absolute URL, you can add a hook in your
 * function.php theme file by doing :
 *
 * add_action("easymigration/urlreplace", function($oldUrl, $newUrl) {
 *  // Do some treatments here
 * }, 11, 2);
 *
 * Please note the this hook is called at "init" action. See http://codex.wordpress.org/Plugin_API/Action_Reference
 *
 * @author obarou@webqam.fr
 */
class EasyMigration {

    /**
     * Hook name.
     *
     * @var string
     */
    private $actionName = "easymigration/urlreplace";

    /**
     * Website old URL.
     *
     * @var string|null
     */
    private $oldUrl = null;

    /**
     * Website new URL.
     *
     * @var string|null
     */
    private $newUrl = null;

    /**
     * Has migration has been done ?
     *
     * @var bool
     */
    private $migrationDone = false;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->oldUrl = isset($_POST["wp_em_oldurl"]) ? $_POST["wp_em_oldurl"] : null;
        $this->newUrl = isset($_POST["wp_em_newurl"]) ? $_POST["wp_em_newurl"] : null;
    }

    /**
     * Plugin initialisation.
     *
     * Execute easymigration/urlreplace hook
     *
     */
    public function init() {

        if (!is_admin() or !current_user_can("manage_options"))
            return;

        $this->registerActions();
        $this->doAction();

        $this->registerAdminMenu();

    }

    /**
     * Register some default migration actions.
     */
    private function registerActions() {

        if (empty($this->oldUrl) or empty($this->newUrl))
            return;

        // Serialized theme options replacement
        add_action($this->actionName, function($oldUrl, $newUrl) {

            $themeSlug = basename(get_stylesheet_directory());

            $themeOptionsName = sprintf("theme_mods_%s", $themeSlug);
            $opts = get_option($themeOptionsName);

            // Asserts option existence
            if (!$opts)
                return;

            foreach ($opts as &$opt) {

                if (!is_string($opt))
                    continue;

                $opt = str_replace($oldUrl, $newUrl, $opt);

            }

            update_option($themeOptionsName, $opts);

        }, 9, 2);

        // Generic replacement
        add_action($this->actionName, function($oldUrl, $newUrl) {

            global $wpdb;

            $requests = array(
                "UPDATE `wp_options`
                SET `option_value` = replace(`option_value`, '$oldUrl', '$newUrl')
                WHERE `option_name` = 'home' OR `option_name` = 'siteurl';",

                "UPDATE `wp_posts`
                SET `post_content` = REPLACE(`post_content`, '$oldUrl', '$newUrl');",

                "UPDATE `wp_posts`
                SET `guid` = REPLACE(`guid`, '$oldUrl', '$newUrl');",

                "UPDATE `wp_postmeta`
                SET `meta_value` = replace(`meta_value`, '$oldUrl', '$newUrl');",
            );

            foreach ($requests as $request)
                $wpdb->query($request);

        }, 11, 2);

        // Drop all transients
        add_action($this->actionName, function($oldUrl, $newUrl) {

            global $wpdb;

            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM $wpdb->options
                     WHERE option_name LIKE %s;",
                    "%_transient_%"
                )
            );

        }, 11, 2);

    }

    /**
     * Execute hook.
     */
    private function doAction() {

        if (empty($this->oldUrl) or empty($this->newUrl))
            return;

        do_action($this->actionName, $this->oldUrl, $this->newUrl);

        $this->migrationDone = true;

    }

    /**
     * Register admin menu.
     */
    private function registerAdminMenu() {

        $migrationDone = $this->migrationDone;

        add_action('admin_menu', function() use ($migrationDone) {

            add_management_page(
                __('Migration', 'webqam'),
                __('Migration', 'webqam'),
                'manage_options',
                'easy-migration',
                function() use ($migrationDone) {
                    include __DIR__ . "/templates/admin.php";
                });

        });

    }


}

// Initialize plugin
add_action("init", function() {
    $em = new EasyMigration();
    $em->init();
});