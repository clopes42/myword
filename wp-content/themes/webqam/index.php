<?php get_header(); ?>

<div id="main-content" class="main-content">

    <section class="primary" class="content-area">
        <div class="site-content" role="main">

        <?php
            if ( have_posts() ) :
                // Start the Loop.
                while ( have_posts() ) : the_post();

                    /*
                     * Include the post format-specific template for the content. If you want to
                     * use this in a child theme, then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    get_template_part( 'content/content', get_post_format() );

                endwhile;
            else :
                // If no content, include the "No posts found" template.
                get_template_part( 'content/content', 'none' );

            endif;
        ?>

        </div>
    </section>

    <?php get_sidebar( 'content' ); ?>

</div>

<?php
get_footer();
