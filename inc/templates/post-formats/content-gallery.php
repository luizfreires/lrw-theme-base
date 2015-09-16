<?php
/**
 * The template for displaying posts in the Gallery post format
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>  itemscope="" itemtype="http://schema.org/Article">
    <header class="entry-header">
        <?php
            if ( is_single() ) :
                the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' );

            else :
                the_title( '<h1 class="entry-title" itemprop="name headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );

            endif;

            // Retrieve metadata of metabox.
            $odin_post_gallery = rwmb_meta( 'odin_post_gallery', 'type=image_advanced&size=post_format_gallery' );
            if ( $odin_post_audio ) :
        ?>

            <div id="post-format-gallery" class="flexslider">
                <ul class="slides">
                    <?php foreach ( $odin_post_gallery as $images ) : ?>
                        <li><img src="<?php echo $images['url']; ?>" /></li>
                    <?php endforeach; ?>
                </ul>
            </div>

        <?php endif; ?>

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
