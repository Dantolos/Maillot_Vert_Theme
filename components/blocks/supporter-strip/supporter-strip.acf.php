<?php 
if( function_exists('acf_add_local_field_group') ):

     acf_add_local_field_group( array(
          'key' => 'group_65a8e0732daed',
          'title' => 'B | Support Strip',
          'fields' => array(
               array(
                    'key' => 'field_65a8e6c92976f',
                    'label' => 'Title',
                    'name' => 'title',
                    'aria-label' => '',
                    'type' => 'text',
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
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
               ),
               array(
                    'key' => 'field_65a8e073d517e',
                    'label' => 'Supporters',
                    'name' => 'supporters',
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
                         0 => 'supporter',
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
                         'param' => 'block',
                         'operator' => '==',
                         'value' => 'acf/supporter-strip',
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

endif;