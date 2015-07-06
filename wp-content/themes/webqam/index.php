<?php get_header(); ?>


<div id="main-content" class="main-content">

    
    
    <section class="banner banner1">
        <div class="bg-banner1"></div>
    </section>
    
    
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
    
    <section class="banner banner2" id="banner2">
        <div class="bg-banner2"></div>
    </section>
    
    
    <section class="carouseltest">
        <div class="bloc bloc1"><img src="http://dummyimage.com/200x200/000/fff" alt=""></div>
        <div class="bloc bloc2"><img src="http://dummyimage.com/200x200/000/fff" alt=""></div>
        <div class="bloc bloc3"><img src="http://dummyimage.com/200x200/000/fff" alt=""></div>
        <div class="bloc bloc4"><img src="http://dummyimage.com/200x200/000/fff" alt=""></div>
        <div class="bloc bloc5"><img src="http://dummyimage.com/200x200/000/fff" alt=""></div>
        <div class="bloc bloc6"><img src="http://dummyimage.com/200x200/000/fff" alt=""></div>
    </section>
    
    
<!--    
    <section id="images" class="wrapper">
      <p class="images-byline">Or better yet, a realistic example of showcasing some design work.</p>
      <p class="images-byline-2">Really, anything is possible &hellip;</p>
      <img id="mediumHomepage" class="raw-page" src="http://davegamache.com/parallax/img/oversized-raw-homepage.jpg">
      <div class="iphone">
        <img class="iphone-frame" src="http://davegamache.com/parallax/img/iphoneframe.png">
        <div class="iphone-viewport">
          <img id="medium-profile-iphone" class="iphone-content" src="http://davegamache.com/parallax/img/medium-profile-iphone-fullsize.jpg">
          <img id="davegamache-dot-com" class="iphone-content" src="http://davegamache.com/parallax/img/davegamache-rotated.jpg">
        </div>
      </div>
    </section>-->
    
    
    <section class="secondary">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, adipisci?</p>
    </section>

    <?php get_sidebar( 'content' ); ?>

</div>
test
<?php
get_footer();
