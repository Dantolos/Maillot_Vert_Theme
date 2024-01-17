<?php 
if( function_exists('acf_add_local_field_group') ):
     acf_add_local_field_group( array(
          'key' => 'group_65a7cb7d9a6a1',
          'title' => 'B | Gallery Slider',
          'fields' => array(
               array(
                    'key' => 'field_65a7cb7d1bff1',
                    'label' => 'Images',
                    'name' => 'images',
                    'aria-label' => '',
                    'type' => 'gallery',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                         'width' => '',
                         'class' => '',
                         'id' => '',
                    ),
                    'wpml_cf_preferences' => 1,
                    'return_format' => 'url',
                    'library' => 'all',
                    'min' => '',
                    'max' => '',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                    'insert' => 'append',
                    'preview_size' => 'medium',
               ),
          ),
          'location' => array(
               array(
                    array(
                         'param' => 'block',
                         'operator' => '==',
                         'value' => 'acf/gallery-slider',
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