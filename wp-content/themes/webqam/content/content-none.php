<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<header class="page-header">
    <h1 class="page-title"><?php _e( 'Contenu introuvable', 'webqam' ); ?></h1>
</header>

<div class="page-content">


    <?php if ( is_search() ) : ?>

    <p><?php _e( "Désolé, votre recherche n'a retournée aucun résultat.", 'webqam' ); ?></p>
    <?php get_search_form(); ?>

    <?php else : ?>

    <p><?php _e( "Le contenu que vous cherchez n'est'pas ici. Essayez la recherche : ", 'webqam' ); ?></p>
    <?php get_search_form(); ?>

    <?php endif; ?>
</div>
