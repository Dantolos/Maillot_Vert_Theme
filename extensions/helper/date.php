<?php
/**
 * Date and time formatting helpers.
 *
 * @package MaillotVert
 */

namespace mv\helper\date;

defined( 'ABSPATH' ) || exit;

/**
 * Language aware date/time formatting.
 *
 * The previous implementation used strftime() and setlocale(), both of which
 * are deprecated since PHP 8.1 and removed in PHP 9, and it formatted with the
 * server timezone instead of the site's. This version uses IntlDateFormatter
 * when the intl extension is available and falls back to wp_date() otherwise.
 */
class Date_Format {

	/**
	 * Format a value as a localised time or date string.
	 *
	 * @param mixed  $value Date/time string as stored by ACF.
	 * @param string $type  Either "time" or "date".
	 *
	 * @return string Empty string when the value cannot be parsed.
	 */
	public function formating_Date_Language( $value, $type = 'date' ): string { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid -- Public API kept for backwards compatibility.
		$timestamp = $this->to_timestamp( $value );

		if ( null === $timestamp ) {
			return '';
		}

		$lang = $this->language();

		if ( 'time' === $type ) {
			// Midnight is the "no time given" marker used by the editors.
			if ( '00:00' === wp_date( 'H:i', $timestamp ) ) {
				return '';
			}

			switch ( $lang ) {
				case 'de':
					/* translators: %s: time, e.g. 14:30. */
					return sprintf( __( '%s Uhr', 'maillot-vert' ), wp_date( 'H:i', $timestamp ) );
				case 'fr':
					return (string) wp_date( "H\\hi", $timestamp );
				case 'en':
					return (string) wp_date( 'g:i a', $timestamp );
				default:
					return (string) wp_date( 'H:i', $timestamp );
			}
		}

		return $this->format_date( $timestamp, $lang );
	}

	/**
	 * Format a date in the given language.
	 *
	 * @param int    $timestamp Unix timestamp.
	 * @param string $lang      Two letter language code.
	 *
	 * @return string
	 */
	protected function format_date( int $timestamp, string $lang ): string {
		if ( class_exists( '\IntlDateFormatter' ) ) {
			$locale = [
				'de' => 'de_CH',
				'fr' => 'fr_CH',
				'en' => 'en_GB',
			][ $lang ] ?? 'de_CH';

			$formatter = new \IntlDateFormatter(
				$locale,
				\IntlDateFormatter::LONG,
				\IntlDateFormatter::NONE,
				wp_timezone()
			);

			$formatted = $formatter->format( $timestamp );

			if ( false !== $formatted ) {
				return (string) $formatted;
			}
		}

		// Fallback: wp_date() localises month names through WordPress itself.
		return (string) wp_date( 'en' === $lang ? 'j F Y' : 'j. F Y', $timestamp );
	}

	/**
	 * Current language code.
	 *
	 * @return string
	 */
	protected function language(): string {
		if ( function_exists( 'mv_current_language' ) ) {
			return mv_current_language();
		}

		$lang = apply_filters( 'wpml_current_language', null );

		return $lang ? (string) $lang : substr( (string) get_locale(), 0, 2 );
	}

	/**
	 * Turn an ACF date/time value into a timestamp in the site's timezone.
	 *
	 * @param mixed $value Raw field value.
	 *
	 * @return int|null
	 */
	protected function to_timestamp( $value ): ?int {
		if ( $value instanceof \DateTimeInterface ) {
			return $value->getTimestamp();
		}

		if ( is_numeric( $value ) ) {
			return (int) $value;
		}

		if ( ! is_string( $value ) || '' === trim( $value ) ) {
			return null;
		}

		$value = str_replace( '/', '-', trim( $value ) );

		// Anything without a digit cannot be a date or a time.
		if ( ! preg_match( '/\d/', $value ) ) {
			return null;
		}

		// A bare "H:i" or "H:i:s" has no date part – anchor it to today.
		if ( preg_match( '/^\d{1,2}:\d{2}(:\d{2})?$/', $value ) ) {
			$value = wp_date( 'Y-m-d' ) . ' ' . $value;
		}

		try {
			$date = new \DateTimeImmutable( $value, wp_timezone() );
		} catch ( \Exception $e ) {
			return null;
		}

		return $date->getTimestamp();
	}

	/**
	 * All timestamps between two dates.
	 *
	 * Example: date_range( '2014-01-01', '2014-01-20', '+1 day' ).
	 *
	 * @param string $first First date.
	 * @param string $last  Last date.
	 * @param string $step  strtotime() compatible step.
	 *
	 * @return int[]
	 */
	public function date_range( string $first, string $last, string $step = '+1 day' ): array {
		$start = $this->to_timestamp( $first );
		$end   = $this->to_timestamp( $last );

		if ( null === $start || null === $end || $start > $end ) {
			return [];
		}

		$dates   = [];
		$current = $start;
		$guard   = 0;

		while ( $current <= $end && $guard < 10000 ) {
			$dates[] = $current;
			$next    = strtotime( $step, $current );

			if ( false === $next || $next <= $current ) {
				break;
			}

			$current = $next;
			++$guard;
		}

		return $dates;
	}
}
