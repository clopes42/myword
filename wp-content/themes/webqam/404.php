<?php
/**
 * 404 template.
 *
 * @package WordPress
 * @subpackage Webqam
 * @since Webqam 0.1
 */

get_header(); ?>

    <div id="main-content" class="main-content">

        <section class="primary" class="content-area">

            <div class="site-content" role="main">

                <p><?php _e( "La page à laquelle vous tentez d'accéder n'existe pas.", 'webqam' ); ?></p>

                <p>
                    <a href="<?php echo home_url(); ?>">
                        <?php _e( "Retour à l'accueil ? ", 'webqam' ); ?>
                    </a>
                </p>

            </div>

        </section>

        <?php get_sidebar( 'content' ); ?>

    </div>

<?php
get_footer();
