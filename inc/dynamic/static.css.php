<?php

/**
 * Auto create .css file from Theme Options
 * @author Fox
 * @version 1.0.0
 */
/*
 * Convert HEX to RGBA
 */
if ( ! function_exists( 'wp_libra_hex_to_rgb' ) ) {
	function wp_libra_hex_to_rgb( $hex, $opacity = 1 ) {
		$hex = str_replace( '#', '', (string) $hex );
		$color = array();

		if ( strlen( $hex ) === 3 ) {
			$color['r'] = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$color['g'] = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$color['b'] = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			$color['a'] = $opacity;
		} elseif ( strlen( $hex ) === 6 ) {
			$color['r'] = hexdec( substr( $hex, 0, 2 ) );
			$color['g'] = hexdec( substr( $hex, 2, 2 ) );
			$color['b'] = hexdec( substr( $hex, 4, 2 ) );
			$color['a'] = $opacity;
		} else {
			return 'rgba(0, 0, 0, ' . floatval( $opacity ) . ')';
		}

		return 'rgba(' . implode( ', ', $color ) . ')';
	}
}

class CMSSuperHeroes_StaticCss {

	/**
	 * SCSS compiler instance.
	 *
	 * @var scssc
	 */
	public $scss;

	function __construct() {
		global $smof_data;

		/* scss */
		$this->scss = new scssc();

		/* set paths scss */
		$this->scss->setImportPaths( get_template_directory() . '/assets/scss/' );

		/* generate css over time */
		if ( isset( $smof_data['dev_mode'] ) && $smof_data['dev_mode'] ) {
			$this->generate_file();
		} else {
			/* save option generate css */
			add_action(
				'redux/options/smof_data/saved',
				array(
					$this,
					'generate_file',
				)
			);
		}
	}

	/**
	 * generate css file.
	 *
	 * @since 1.0.0
	 */
	public function generate_file() {
		global $smof_data, $wp_filesystem;

		if ( empty( $smof_data ) ) {
			return;
		}

		if ( empty( $wp_filesystem ) ) {
			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
			WP_Filesystem();
		}

		if ( empty( $wp_filesystem ) ) {
			return;
		}

		$options_scss = get_template_directory() . '/assets/scss/options.scss';
		$options_css  = $this->css_render();

		/* Guard against notice/HTML pollution in generated SCSS. */
		$options_css = preg_replace( '/<[^>]+>/', '', $options_css );

		/* write options to scss file */
		$wp_filesystem->put_contents( $options_scss, $options_css, FS_CHMOD_FILE );

		/* minimize CSS styles */
		if ( empty( $smof_data['dev_mode'] ) ) {
			$this->scss->setFormatter( 'scss_formatter_compressed' );
		}

		/* compile scss to css */
		$css = $this->scss_render();

		if ( false === $css || '' === $css ) {
			return;
		}

		$file = 'static.css';

		if ( ! empty( $smof_data['presets_color'] ) ) {
			$file = 'presets-' . $smof_data['presets_color'] . '.css';
		}

		$file = get_template_directory() . '/assets/css/' . $file;

		/* Normalize to Unix LF — mixed line endings fail ThemeForest Theme Check / SVN. */
		$css = str_replace( array( "\r\n", "\r" ), "\n", $css );

		/* write static.css file */
		$wp_filesystem->put_contents( $file, $css, FS_CHMOD_FILE );
	}

	/**
	 * scss compile
	 *
	 * @since 1.0.0
	 * @return string|false
	 */
	public function scss_render() {
		try {
			return $this->scss->compile( '@import "master.scss"' );
		} catch ( Exception $e ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG && current_user_can( 'manage_options' ) ) {
				error_log( 'WP Libra SCSS compile error: ' . $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			}
			return false;
		}
	}

	/**
	 * main css
	 *
	 * Build SCSS/CSS option overrides as a string (do not use output buffering —
	 * PHP notices/deprecations would otherwise pollute options.scss and fatal the site).
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function css_render() {
		global $smof_data;

		$css = '';

		$primary_color = ! empty( $smof_data['primary_color'] ) ? $smof_data['primary_color'] : '#e7cd3b';
		$css          .= '$primary_color:' . esc_attr( $primary_color ) . ';';

		/* ==========================================================================
		   Start Body
		========================================================================== */
		$css .= 'blockquote {
                background-color:' . wp_libra_hex_to_rgb( $primary_color, 0.3 ) . ';
            }';

		if ( ! empty( $smof_data['slider_height']['height'] ) ) {
			$css .= '#slider-wrapper .cs-slider-wrapper .post-thumbnail {
                height:' . esc_attr( $smof_data['slider_height']['height'] ) . ';
            }';
		}

		$css .= 'body .gallery .gallery-item a::before {
                background-color:' . wp_libra_hex_to_rgb( $primary_color, 0.6 ) . ';
            }';

		$css .= '.feature-content:before {
                background-color:' . wp_libra_hex_to_rgb( $primary_color, 0.9 ) . ';
            }';
		/* ==========================================================================
		   End Body
		========================================================================== */

		return $css;
	}
}

new CMSSuperHeroes_StaticCss();
