<?php

if ( ! function_exists( 'vampires_journal_support' ) ) :
	function vampires_journal_support()  {

		// Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );
	}
	add_action( 'after_setup_theme', 'vampires_journal_support' );
endif;

/**
 * Enqueue scripts and styles.
 */
function vampires_journal_scripts() {
	// Enqueue theme stylesheet.
	wp_enqueue_style( 'vampires-journal-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
}

add_action( 'wp_enqueue_scripts', 'vampires_journal_scripts' );
