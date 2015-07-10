<?php

/**
 * Angular Experiments.
 * Enqueue scripts and styles for the front end.
 *
 * @since 1.0.0
 */
function ae_scripts()
{

    // Load main stylesheet.
    wp_enqueue_style('ae-style', get_stylesheet_uri());

    // Load Angular
    wp_enqueue_script('ae-angular', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.js', array(), '', true);
    wp_enqueue_script('ae-angular-router', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-route.js', array(
        'ae-angular'), '', true);
    wp_enqueue_script('ae-angular-sanitize', '//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-sanitize.js', array(
        'ae-angular'), '', true);

    // Load custom app script
    wp_enqueue_script('ae-js', get_template_directory_uri() . '/js/app.js', array(), '', true);

    // Variables for app script
    wp_localize_script('ae-js', 'aeJS', array(
        'api' => get_bloginfo('wpurl') . '/wp-json',
        'partials' => trailingslashit(get_template_directory_uri()) . 'partials/',
            )
    );


}

add_action('wp_enqueue_scripts', 'ae_scripts');



    add_theme_support('menus');
    register_nav_menu('main-nav', 'Navigation principale');
    register_nav_menu('footer-nav', 'Footer');