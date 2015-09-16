<?php
/**
 * Template Name: Canvas (full width)
 *
 * This template is used for display a page with full width
 * in combination with the plugin SiteOrigin Page Builder.
 *
 * On activation of the theme there is an alert about plugins required/optional
 */

get_header(); ?>

	<main id="content" class="<?php echo odin_classes_page_full(); ?>" tabindex="-1" role="main">

		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'inc/templates/pages/content', 'page-canvas' );
			endwhile;
		?>

	</main><!-- #main -->

<?php
get_footer();
