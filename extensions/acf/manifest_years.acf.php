<?php
/**
 * "Jahr" taxonomy for manifests.
 *
 * The only categorisation for now. A second axis (key contact / key moment /
 * key learning) would be registered exactly like this one.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_taxonomy(
			'manifest-year',
			[ 'manifest' ],
			[
				'labels'            => [
					'name'          => 'Jahre',
					'singular_name' => 'Jahr',
					'menu_name'     => 'Jahre',
					'all_items'     => 'Alle Jahre',
					'edit_item'     => 'Jahr bearbeiten',
					'add_new_item'  => 'Neu hinzufügen: Jahr',
					'new_item_name' => 'Name des neuen Jahres',
					'search_items'  => 'Jahre suchen',
					'not_found'     => 'Keine Jahre gefunden',
					'back_to_items' => '← Zu den Jahren',
				],
				'hierarchical'      => true,
				'public'            => false,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'publicly_queryable' => false,
				'rewrite'           => false,
			]
		);
	}
);
