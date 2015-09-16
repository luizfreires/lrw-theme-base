<?php
/**
 * Load Site Scripts and Styles
 */
function odin_setup_scripts_and_styles() {

	$template_url = get_template_directory_uri();

	if ( ! is_admin() ) {

		// Loads main stylesheet.
		wp_enqueue_style( 'main-style', get_stylesheet_uri(), array(), null, 'all' );

		// jQuery.
		wp_enqueue_script( 'jquery' );

		// General scripts.
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

			// Bootstrap.
			wp_enqueue_script( 'bootstrap', $template_url . '/assets/js/libs/bootstrap.min.js', array(), null, true );

			// FitVids.
			wp_enqueue_script( 'fitvids', $template_url . '/assets/js/libs/jquery.fitvids.js', array(), null, true );

			// Main jQuery.
			wp_enqueue_script( 'main', $template_url . '/assets/js/main.js', array(), null, true );

		} else {
			// Grunt main file with Bootstrap, FitVids and others libs.
			wp_enqueue_script( 'main-min', $template_url . '/assets/js/main.min.js', array(), null, true );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'odin_setup_scripts_and_styles' );
