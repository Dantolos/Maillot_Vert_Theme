<?php
/**
 * Fields for the manifest post type, plus the site-wide attribution switch.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'acf/include_fields',
	function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			[
				'key'                   => 'group_mv_manifest',
				'title'                 => 'Manifest',
				'fields'                => [
					[
						'key'          => 'field_mv_manifest_statement',
						'label'        => 'Statement',
						'name'         => 'statement',
						'type'         => 'textarea',
						'instructions' => 'Die Antwort der teilnehmenden Person. Zeilenumbrüche werden zu Absätzen.',
						'required'     => 1,
						'rows'         => 7,
						'new_lines'    => '',
						'wpml_cf_preferences' => 2,
					],
					[
						'key'          => 'field_mv_manifest_author_name',
						'label'        => 'Name',
						'name'         => 'author_name',
						'type'         => 'text',
						'instructions' => 'Wird derzeit NICHT ausgegeben – die Karten sind anonym. Sobald unter Theme Settings → Manifeste die Namensnennung aktiviert wird, erscheint dieser Name auf der Karte.',
						'required'     => 0,
						'wpml_cf_preferences' => 1,
					],
					[
						'key'          => 'field_mv_manifest_author_role',
						'label'        => 'Funktion oder Ort',
						'name'         => 'author_role',
						'type'         => 'text',
						'instructions' => 'Optionale Zeile unter dem Namen, zum Beispiel „Teilnehmerin, Zürich“. Wird zusammen mit dem Namen ausgegeben.',
						'required'     => 0,
						'wpml_cf_preferences' => 2,
					],
				],
				'location'              => [
					[
						[
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'manifest',
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

		acf_add_local_field_group(
			[
				'key'                   => 'group_mv_manifest_settings',
				'title'                 => 'Manifeste',
				'fields'                => [
					[
						'key'           => 'field_mv_manifest_show_authors',
						'label'         => 'Namen anzeigen',
						'name'          => 'manifest_show_authors',
						'type'          => 'true_false',
						'instructions'  => 'Aus: die Karten bleiben anonym und zeigen nur das Jahr. An: Name und Funktion werden ausgegeben, sofern am jeweiligen Manifest hinterlegt.',
						'default_value' => 0,
						'ui'            => 1,
						'ui_on_text'    => 'an',
						'ui_off_text'   => 'aus',
					],
				],
				'location'              => [
					[
						[
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-settings',
						],
					],
				],
				'menu_order'            => 10,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			]
		);
	}
);
