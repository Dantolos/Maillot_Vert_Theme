<?php
add_action( 'acf/include_fields', function() {

	acf_add_local_field_group( array(
	'key' => 'group_65a94667016b4',
	'title' => 'Footer Fields',
	'fields' => array(
          array(
			'key' => 'field_65a94a20ff04b',
			'label' => 'Linkedin Link',
			'name' => 'linkedin_link',
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
		array(
			'key' => 'field_65a94667528d8',
			'label' => 'Footer Copyright Bar Links',
			'name' => 'footer_copyright_bar_links',
			'aria-label' => '',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 1,
			'post_type' => array(
				0 => 'page',
			),
			'post_status' => '',
			'taxonomy' => '',
			'return_format' => 'id',
			'multiple' => 1,
			'allow_null' => 0,
			'bidirectional' => 0,
			'ui' => 1,
			'bidirectional_target' => array(
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'footer',
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

