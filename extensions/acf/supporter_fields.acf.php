<?php
add_action( 'acf/include_fields', function() {

	acf_add_local_field_group( array(
	'key' => 'group_65a8d88152a85',
	'title' => 'Supporter | Fields',
	'fields' => array(
		array(
			'key' => 'field_65cc7ea2a85b1',
			'label' => 'Logos',
			'name' => 'logos',
			'aria-label' => '',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '40',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 1,
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_65a8d88140ab9',
					'label' => 'Logo',
					'name' => 'logo',
					'aria-label' => '',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 1,
					'return_format' => 'url',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
					'preview_size' => 'medium',
				),
				array(
					'key' => 'field_65cc7ecaa85b2',
					'label' => 'Logo Negativ',
					'name' => 'logo_negativ',
					'aria-label' => '',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 1,
					'return_format' => 'url',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
					'preview_size' => 'medium',
				),
			),
		),
		array(
			'key' => 'field_65a8d8c4ea6bd',
			'label' => 'Informationss',
			'name' => 'informationss',
			'aria-label' => '',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '60',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 1,
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_65a8d8e1ea6be',
					'label' => 'Description',
					'name' => 'description',
					'aria-label' => '',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 2,
					'default_value' => '',
					'maxlength' => '',
					'rows' => 4,
					'placeholder' => '',
					'new_lines' => '',
				),
				array(
					'key' => 'field_65a8d8efea6bf',
					'label' => 'Website',
					'name' => 'website',
					'aria-label' => '',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 1,
					'default_value' => '',
					'placeholder' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'supporter',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	'acfml_field_group_mode' => 'translation',
) );
} );

