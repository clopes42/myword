<?php
/*
Template Name: Page-example
*/

get_header(); ?>

    <div id="main-content" class="main-content">

        <section class="primary" class="content-area">
            <div class="site-content" role="main">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php

                        if ( is_single() ) :
                            the_title( '<h1 class="entry-title">', '</h1>' );
                        else :
                            the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
                        endif;
                        ?>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_content();
                        ?>
                    </div><!-- .entry-content -->
                </article><!-- #post-## -->
            </div>
        </section>

        <?php get_sidebar( 'content' ); ?>

    </div>

<?php
get_footer();
get_footer();
