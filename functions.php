<?php

if ( ! function_exists( 'vampires_journal_support' ) ) :
	function vampires_journal_support()  {
		// Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Enqueue Google fonts.
		add_editor_style(
			array(
				vampires_journal_fonts_url()
			)
		);
	}
	add_action( 'after_setup_theme', 'vampires_journal_support' );
endif;

/**
 * Enqueue scripts and styles.
 */
function vampires_journal_scripts() {
	// Enqueue Google fonts
	wp_enqueue_style( 'vampires-journal-fonts', vampires_journal_fonts_url(), array(), null );

	// Enqueue theme stylesheet.
	wp_enqueue_style( 'vampires-journal-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'vampires_journal_scripts' );

/**
 * Add Google webfonts
 *
 * This function is largely borrowed from the Blockbase theme by Automattic:
 * https://github.com/Automattic/themes/tree/trunk/blockbase
 *
 * @return $fonts_url
 */

function vampires_journal_fonts_url() {
	if ( ! class_exists( 'WP_Theme_JSON_Resolver_Gutenberg' ) ) {
		return '';
	}

	$theme_data = WP_Theme_JSON_Resolver_Gutenberg::get_merged_data()->get_settings();
	if ( empty( $theme_data ) || empty( $theme_data['typography'] ) || empty( $theme_data['typography']['fontFamilies'] ) ) {
		return '';
	}

	$font_families = [];
	if ( ! empty( $theme_data['typography']['fontFamilies']['custom'] ) ) {
		foreach( $theme_data['typography']['fontFamilies']['custom'] as $font ) {
			if ( ! empty( $font['google'] ) ) {
				$font_families[] = $font['google'];
			}
		}

	// NOTE: This should be removed once Gutenberg 12.1 lands stably in all environments
	} else if ( ! empty( $theme_data['typography']['fontFamilies']['user'] ) ) {
		foreach( $theme_data['typography']['fontFamilies']['user'] as $font ) {
			if ( ! empty( $font['google'] ) ) {
				$font_families[] = $font['google'];
			}
		}
	// End Gutenberg < 12.1 compatibility patch

	} else {
		if ( ! empty( $theme_data['typography']['fontFamilies']['theme'] ) ) {
			foreach( $theme_data['typography']['fontFamilies']['theme'] as $font ) {
				if ( ! empty( $font['google'] ) ) {
					$font_families[] = $font['google'];
				}
			}
		}
	}

	if ( empty( $font_families ) ) {
		return '';
	}

	// Make a single request for the theme or user fonts.
	return esc_url_raw( 'https://fonts.googleapis.com/css2?' . implode( '&', array_unique( $font_families ) ) . '&display=swap' );
}

