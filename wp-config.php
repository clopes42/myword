<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */


/**
 * Webqam
 */
// Environnements
define('ENV_PRODUCTION', 'prod');
define('ENV_DEVELOPMENT', 'dev');
define('ENV_PREPRODUCTION', 'preprod');

//  Overwrite REMOTE_ADDR if server is behind a proxy
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
}

define('LOCAL_WORK', isset($_SERVER['APPLICATION_ENV']) && $_SERVER['APPLICATION_ENV'] === 'development');

if (!defined('APPLICATION_ENV')) {

    define('APPLICATION_ENV', call_user_func(function() {
        if (LOCAL_WORK || strpos($_SERVER['HTTP_HOST'], 'dev') !== false || php_sapi_name() == "cli") {
            return ENV_DEVELOPMENT;
        } elseif (strpos($_SERVER['HTTP_HOST'], 'webqamapps') !== false) {
            return ENV_PREPRODUCTION;
        } else {
            return ENV_PRODUCTION;
        }
    }));

}

define('IS_WEBQAM', LOCAL_WORK
    || (isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], array('109.74.86.150', '88.167.113.84'))));

//  Quick tests
defined('IS_DEVELOPMENT') || define('IS_DEVELOPMENT', APPLICATION_ENV === ENV_DEVELOPMENT);
defined('IS_PRODUCTION') || define('IS_PRODUCTION', APPLICATION_ENV === ENV_PRODUCTION);
defined('IS_PREPRODUCTION') || define('IS_PREPRODUCTION', APPLICATION_ENV === ENV_PREPRODUCTION);

/*
 * HEADS UP !
 * The following constants override database values
 * wp_options.option_name = 'siteurl'
 * wp_options.option_name = 'home'
 */
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST']);
define('WP_HOME', WP_SITEURL);
define('WP_CONTENT_URL', WP_SITEURL . '/wp-content');
define('WP_CONTENT_DIR', dirname(__FILE__) . '/wp-content');

if (IS_DEVELOPMENT) {

    //  DB
    define('DB_NAME', 'myword');
    define('DB_USER', 'myword');
    define('DB_PASSWORD', '0000');
    define('DB_HOST', 'localhost');

} elseif (IS_PREPRODUCTION) {

    //  DB
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'sql');
} else {

    /*
     * PRODUCTION CONSTANTS
     * Edit with caution.
     */

    //  DB
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'sql');
}

//  Avoid Error 500
define('WP_MEMORY_LIMIT', '128M');
define('WP_MAX_MEMORY_LIMIT', '128M');


/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données.
 * N'y touchez que si vous savez ce que vous faites.
 */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Zhhg/(hg!:frr.Y 6P&gdsf,5S^4zr=%|sQ2X|.VdGoE$<Of]<X5|yJ');
define('SECURE_AUTH_KEY', '2vgRSlG +nb5sq-|4gs3f53bw5#]kX>?v5tKW(-|-E+1tY$d0pDZgYxEzY`|XSP6`S');
define('LOGGED_IN_KEY', 'c+)&%H`$}nAYL~kM>U)r(s-3f5ds4wIzWQy$Sl<5L!XrQ?EPffQ|WR`*D&>I');
define('NONCE_KEY', '-yc/RUpXyiph_iV{;l&G--xIHrilvR@f1sd3ql92mq3z2-~1|!%`wvt++Q)=^J>_|Z27');
define('AUTH_SALT', '!ojXa<AB _PM~W5dD2C105)7K~AjCd;<J-B1fsd3q5H a/MBi*sw)@yk/8<-b%KF}n%}');
define('SECURE_AUTH_SALT', '*xSz13)mefD~CIVzj~hNP+d4]El.xGief43sd^u-510{zdpAIXE``!e8y67p81l{+8X');
define('LOGGED_IN_SALT', '5EZ;NrB[65%LNW .1!Z$.;h~>%x8CB?qIlp:8fdsq7Fh|L+_Ht;GTd6!c66esPR%iJ{');
define('NONCE_SALT', 'u@|G{ACI_i.<e6#20),Jk !J^1UUX{t*.PSp]-Z^Gfd54s^ju,C[9.zKg:E]J:o_');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix = 'wp_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');
/**
 * Pour les développeurs : le mode deboguage de WordPress.
 */
$wqDebug = IS_DEVELOPMENT OR (IS_WEBQAM AND isset($_REQUEST["wq_debug"]));
$wqDebugLog = IS_DEVELOPMENT OR (IS_WEBQAM AND isset($_REQUEST["wq_debug_log"]));

define('WP_DEBUG', $wqDebug or $wqDebugLog);
define('WP_DEBUG_LOG', $wqDebugLog);
define('WP_DEBUG_DISPLAY', $wqDebugLog);

/**
 * Print wordpress queries
 */
//define('SAVEQUERIES', true);
//if (current_user_can('administrator')) {
//    global $wpdb;
//    echo '<pre>' . print_r($wpdb->queries, true) . '</pre>';
//}

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/**
 * Liste des autres paramètres utiles
 */
//Disable automatic updates
//define('AUTOMATIC_UPDATER_DISABLED', true);
//Activate automatic updates for the core
//define('WP_AUTO_UPDATE_CORE', true);
//Change wp_plugin dir location
//define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/myplugins');
//Change wp_plugin url (must be updated to match the variable above)
//define('WP_PLUGIN_URL', WP_CONTENT_URL . '/myplugins');
//Change upload dir location
//define('UPLOADS', 'my/subdirectory/for/uploads');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');