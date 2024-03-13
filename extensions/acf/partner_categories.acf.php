<?php
add_action( 'init', function() {
	register_taxonomy( 'partner-category', array(
	0 => 'supporter',
), array(
	'labels' => array(
		'name' => 'Partner Categories',
		'singular_name' => 'Partner Category',
		'menu_name' => 'Partner Categories',
		'all_items' => 'Alle Partner Categories',
		'edit_item' => 'Partner Category bearbeiten',
		'view_item' => 'Partner Category anzeigen',
		'update_item' => 'Partner Category aktualisieren',
		'add_new_item' => 'Neu hinzufügen: Partner Category',
		'new_item_name' => 'New Partner Category Name',
		'search_items' => 'Partner Categories suchen',
		'popular_items' => 'Beliebte Partner Categories',
		'separate_items_with_commas' => 'Trenne partner categories durch Kommas',
		'add_or_remove_items' => 'partner categories hinzufügen oder entfernen',
		'choose_from_most_used' => 'Choose from the most used partner categories',
		'not_found' => 'partner categories konnten nicht gefunden werden',
		'no_terms' => 'Keine partner categories-Taxonomien',
		'items_list_navigation' => 'Partner Categories-Listen-Navigation',
		'items_list' => 'Partner Categories-Liste',
		'back_to_items' => '← Zu partner categories gehen',
		'item_link' => 'Partner Category-Link',
		'item_link_description' => 'Ein Link zu einer Taxonomie partner category',
	),
	'public' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );
} );

