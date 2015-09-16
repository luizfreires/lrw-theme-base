<?php
/**
 * The default template for displaying content.
 *
 * Used for both single and index/archive/author/catagory/search/tag.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>  itemscope="" itemtype="http://schema.org/Article">
    <header class="entry-header">
        <?php

            if ( is_single() ) :
                the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' );
                echo odin_thumbnail( 747, '400', $crop = true );

                echo odin_breadcrumbs();
            else :
                the_title( '<h1 class="entry-title" itemprop="name headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
                echo odin_thumbnail( 747, '250', $crop = true );

            endif;
        ?>

        <div class="entry-meta">
            <?php
                if ( 'post' == get_post_type() ) :
                    odin_posted_on();
                endif;

                if ( has_category() ) :
            ?>
                <span class="categories"><?php the_category( ', ' ); ?></span>
            <?php endif; ?>
            <?php if ( has_tag() ) : ?>
                <span class="tags"><?php the_tags( '', ', ', '' ); ?></span>
            <?php endif; ?>
            <?php if ( comments_open() && ! post_password_required() ) : ?>
                <span class="comments">
                    <?php comments_popup_link( __( 'Leave a comment', 'altimar' ), __( '1 Comment', 'altimar' ), __( '% Comments', 'altimar' ) ); ?>
                </span>
            <?php endif; ?>
        </div><!-- .entry-meta -->

    </header><!-- .entry-header -->

    <?php if ( is_search() ) : ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content" itemprop="articleBody">
            <?php
                if ( is_single() ) :
                    the_content();
                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'altimar' ) . '</span>',
                            'after' => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            )
                    );

                else :
                    the_excerpt();

                endif;
            ?>
        </div><!-- .entry-content -->
    <?php endif; ?>
</article><!-- #post-## -->
