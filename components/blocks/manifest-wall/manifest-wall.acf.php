<?php
/**
 * Fields for the manifest wall block.
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
		'key'                   => 'group_mv_manifest_wall',
		'title'                 => 'Manifest Wall',
		'fields'                => [
			[
				'key'                 => 'field_mv_mw_eyebrow',
				'label'               => 'Übertitel',
				'name'                => 'eyebrow',
				'type'                => 'text',
				'default_value'       => 'Manifest',
				'wpml_cf_preferences' => 2,
			],
			[
				'key'                 => 'field_mv_mw_title',
				'label'               => 'Titel',
				'name'                => 'title',
				'type'                => 'text',
				'required'            => 1,
				'wpml_cf_preferences' => 2,
			],
			[
				'key'                 => 'field_mv_mw_question',
				'label'               => 'Frage',
				'name'                => 'question',
				'type'                => 'textarea',
				'instructions'        => 'Dieselbe Frage wie im Teaser, damit die Seite für sich verständlich ist.',
				'rows'                => 3,
				'default_value'       => 'Before you leave, take a moment to reflect. What’s staying with me from tonight? (a key contact, a key moment, a key learning)',
				'wpml_cf_preferences' => 2,
			],
			[
				'key'                 => 'field_mv_mw_intro',
				'label'               => 'Einleitung',
				'name'                => 'intro',
				'type'                => 'textarea',
				'rows'                => 3,
				'wpml_cf_preferences' => 2,
			],
			[
				'key'           => 'field_mv_mw_show_filter',
				'label'         => 'Jahresfilter anzeigen',
				'name'          => 'show_filter',
				'type'          => 'true_false',
				'instructions'  => 'Blendet Schaltflächen für jedes Jahr ein, das Manifeste enthält. Gefiltert wird ohne Neuladen.',
				'default_value' => 1,
				'ui'            => 1,
				'ui_on_text'    => 'an',
				'ui_off_text'   => 'aus',
			],
		],
		'location'              => [
			[
				[
					'param'    => 'block',
					'operator' => '==',
					'value'    => 'acf/manifest-wall',
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
