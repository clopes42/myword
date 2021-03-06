<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <base href="/">
        <title>AJ</title>
        <?php wp_head(); ?>
    </head>
    <body>

        <div id="myapp" ng-app="myapp">
            <header>
                <h1>TEST</h1>
                <p>Display a list of recent posts.</p>

                <nav class="site-navigation primary-navigation" role="navigation">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'main-nav',
                        'menu_class' => 'nav-menu')); ?>
                </nav>
            </header>

            <div ng-view></div>

            <footer>
                &copy; <?php echo date('Y'); ?>
            </footer>

<?php wp_footer(); ?>
        </div>
    </body>
</html>