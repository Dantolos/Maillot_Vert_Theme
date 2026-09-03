<?php
/**
 * Fields for the manifest teaser block.
 *
 * NOTE: no acf/include_fields hook here, on purpose. This file is required from
 * blocks-register.php on `init`, by which time acf/include_fields has already
 * fired - a callback added now would never run. acf_add_local_field_group()
 * writes straight into ACF's local store and is read when the editor asks for
 * the field groups, so calling it directly is both correct and what every other
 * block in this theme does. Field files under extensions/acf/ are loaded at
 * theme load and may use the hook.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group(
	[
		'key'                   => 'group_mv_manifest_teaser',
		'title'                 => 'Manifest Teaser',
		'fields'                => [
			[
				'key'                 => 'field_mv_mt_eyebrow',
				'label'               => 'Übertitel',
				'name'                => 'eyebrow',
				'type'                => 'text',
				'instructions'        => 'Kurzes Label über der Überschrift, zum Beispiel „Stimmen“.',
				'default_value'       => 'Stimmen',
				'wpml_cf_preferences' => 2,
			],
			[
				'key'                 => 'field_mv_mt_title',
				'label'               => 'Titel',
				'name'                => 'title',
				'type'                => 'text',
				'required'            => 1,
				'wpml_cf_preferences' => 2,
			],
			[
				'key'                 => 'field_mv_mt_question',
				'label'               => 'Frage',
				'name'                => 'question',
				'type'                => 'textarea',
				'instructions'        => 'Die Frage, auf die die Manifeste antworten. Wird hervorgehoben dargestellt.',
				'rows'                => 3,
				'default_value'       => 'Before you leave, take a moment to reflect. What’s staying with me from tonight? (a key contact, a key moment, a key learning)',
				'wpml_cf_preferences' => 2,
			],
			[
				'key'                 => 'field_mv_mt_intro',
				'label'               => 'Einleitung',
				'name'                => 'intro',
				'type'                => 'textarea',
				'instructions'        => 'Ein bis zwei Sätze Kontext. Optional.',
				'rows'                => 3,
				'wpml_cf_preferences' => 2,
			],
			[
				'key'                 => 'field_mv_mt_page_link',
				'label'               => 'Link zur Manifest-Seite',
				'name'                => 'page_link',
				'type'                => 'link',
				'return_format'       => 'array',
				'wpml_cf_preferences' => 1,
			],
			[
				'key'                 => 'field_mv_mt_pdf',
				'label'               => 'PDF',
				'name'                => 'pdf',
				'type'                => 'file',
				'instructions'        => 'Dateiname und Größe werden automatisch angezeigt.',
				'return_format'       => 'array',
				'mime_types'          => 'pdf',
				'library'             => 'all',
				'wpml_cf_preferences' => 1,
			],
			[
				'key'                 => 'field_mv_mt_manifests',
				'label'               => 'Manifeste',
				'name'                => 'manifests',
				'type'                => 'relationship',
				'instructions'        => 'Bis zu fünf Manifeste für den Slider. Die Reihenfolge hier ist die Reihenfolge im Slider.',
				'post_type'           => [ 'manifest' ],
				'taxonomy'            => [],
				'filters'             => [ 'search', 'taxonomy' ],
				'return_format'       => 'id',
				'min'                 => 0,
				'max'                 => 5,
				'elements'            => [],
				'wpml_cf_preferences' => 1,
			],
		],
		'location'              => [
			[
				[
					'param'    => 'block',
					'operator' => '==',
					'value'    => 'acf/manifest-teaser',
				],
			],
		],
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'active'                => true,
		'show_in_rest'          => 0,
		'acfml_field_group_mode' => 'translation',
	]
);
