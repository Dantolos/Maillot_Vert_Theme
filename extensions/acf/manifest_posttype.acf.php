<?php
/**
 * "Manifest" post type – short reflections written by participants.
 *
 * Not publicly queryable on purpose: a manifest has no detail page. It is read
 * inside the slider on the home page, on the wall, and in the overlay. Without
 * this, WordPress would expose an empty single view for every entry and let
 * search engines index it.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_post_type(
			'manifest',
			[
				'labels'              => [
					'name'                  => 'Manifeste',
					'singular_name'         => 'Manifest',
					'menu_name'             => 'Manifeste',
					'all_items'             => 'Alle Manifeste',
					'edit_item'             => 'Manifest bearbeiten',
					'view_item'             => 'Manifest anzeigen',
					'add_new_item'          => 'Neu hinzufügen: Manifest',
					'add_new'               => 'Neu hinzufügen: Manifest',
					'new_item'              => 'Neues Manifest',
					'search_items'          => 'Manifeste suchen',
					'not_found'             => 'Keine Manifeste gefunden',
					'not_found_in_trash'    => 'Keine Manifeste im Papierkorb gefunden',
					'items_list'            => 'Manifest-Liste',
					'items_list_navigation' => 'Manifest-Listen-Navigation',
					'item_published'        => 'Manifest wurde veröffentlicht.',
					'item_updated'          => 'Manifest wurde aktualisiert.',
				],
				'description'         => 'Antworten von Teilnehmenden auf die Reflexionsfrage.',
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'rewrite'             => false,
				'menu_position'       => 21,
				'menu_icon'           => 'dashicons-format-quote',
				'supports'            => [ 'title' ],
				'delete_with_user'    => false,
			]
		);
	}
);
