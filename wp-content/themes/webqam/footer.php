<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>


    <footer class="site-footer" role="contentinfo">

        <div class="site-info">
            <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'webqam' ) ); ?>">
                <?php printf( __( 'Fièrement propulsé par %s', 'webqam' ), 'Wordpress' ); ?></a>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div>
    <?php wp_footer(); ?>
</body>
</html>