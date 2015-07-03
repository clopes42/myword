<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <?php wp_head(); ?>

    <meta name="viewport" content="width=device-width">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?=Webqam::getInstance()->getTemplatePartWithVars("partials/analytics.php",
        array("tag" => get_option("ua_tracking_code")))?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
    <?php if ( get_header_image() ) : ?>
    <div id="site-header">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
        </a>
    </div>
    <?php endif; ?>

    <header class="site-header" role="banner">
        <div class="header-main">

            <h1 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>

            <nav class="site-navigation primary-navigation" role="navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'main-nav', 'menu_class' => 'nav-menu' ) ); ?>
            </nav>

        </div>

        <div id="search-container" class="search-box-wrapper hide">
            <div class="search-box">
                <?php get_search_form(); ?>
            </div>
        </div>

    </header>
