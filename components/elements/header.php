<?php
/**
 * Site header component.
 *
 * NOTE: every file in components/elements is require_once'd from functions.php,
 * so this file must only *define* things – never emit markup at load time.
 *
 * @package MaillotVert
 */

namespace mv\components\header {

	defined( 'ABSPATH' ) || exit;

	/**
	 * Site header markup.
	 */
	class Header {

		/**
		 * Rendered markup. Kept public for backwards compatibility with
		 * `$header = new Header; echo $header->html;`.
		 *
		 * @var string
		 */
		public $html = '';

		/**
		 * Build the markup.
		 */
		public function __construct() {
			$this->html = self::markup();
		}

		/**
		 * Build the header markup.
		 *
		 * @return string
		 */
		public static function markup(): string {
			$logo = sprintf(
				'<a class="header-logo-link" href="%1$s" rel="home"><img class="header-logo" src="%2$s" width="260" height="100" alt="%3$s" /></a>',
				esc_url( home_url( '/' ) ),
				esc_url( get_theme_file_uri( 'assets/images/maillot-vert-logo.svg' ) ),
				esc_attr( get_bloginfo( 'name' ) )
			);

			return '<header id="header-container" class="header-container">'
				. $logo
				. self::language_switcher()
				. '</header>';
		}

		/**
		 * WPML language switcher.
		 *
		 * Guarded so the site keeps working when WPML is deactivated – the
		 * previous implementation called icl_get_languages() unconditionally.
		 *
		 * @return string
		 */
		public static function language_switcher(): string {
			if ( ! function_exists( 'icl_get_languages' ) ) {
				return '';
			}

			$languages = icl_get_languages( 'skip_missing=0' );

			if ( ! is_array( $languages ) || count( $languages ) < 2 ) {
				return '';
			}

			$items = '';

			foreach ( $languages as $language ) {
				$code  = strtoupper( (string) ( $language['language_code'] ?? '' ) );
				$label = (string) ( $language['translated_name'] ?? $code );

				if ( ! empty( $language['active'] ) ) {
					$items .= sprintf(
						'<li class="lang-btn"><span class="lang-btn__current" aria-current="true"><span class="screen-reader-text">%1$s </span>%2$s</span></li>',
						esc_html__( 'Current language:', 'maillot-vert' ),
						esc_html( $code )
					);
					continue;
				}

				$items .= sprintf(
					'<li class="lang-btn"><a href="%1$s" lang="%2$s" hreflang="%2$s"><span class="screen-reader-text">%3$s </span>%4$s</a></li>',
					esc_url( (string) ( $language['url'] ?? '' ) ),
					esc_attr( strtolower( $code ) ),
					esc_html( $label ),
					esc_html( $code )
				);
			}

			return sprintf(
				'<nav id="languagebutton" class="language-switcher" aria-label="%1$s"><ul>%2$s</ul></nav>',
				esc_attr__( 'Language', 'maillot-vert' ),
				$items
			);
		}
	}
}

namespace {

	/**
	 * Echo the site header.
	 */
	function mv_site_header(): void {
		echo \mv\components\header\Header::markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped while building.
	}
}
