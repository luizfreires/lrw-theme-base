<?php
/**
 * The template used for displaying page content.
 *
 * @package Odin
 * @since 2.2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <?php
            the_content();
            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'odin' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ) );
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->
