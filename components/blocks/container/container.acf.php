<?php
if( function_exists('acf_add_local_field_group') ):

     acf_add_local_field_group( array(
          'key' => 'group_65a6423ada682',
          'title' => 'B | Container',
          'fields' => array(
               array(
                    'key' => 'field_65a6423b59563',
                    'label' => 'Width',
                    'name' => 'width',
                    'aria-label' => '',
                    'type' => 'button_group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                         'width' => '',
                         'class' => '',
                         'id' => '',
                    ),
                    'wpml_cf_preferences' => 1,
                    'choices' => array(
                         'full' => 'Full',
                         'default' => 'Default',
                         90 => '90%',
                         80 => '80%',
                         75 => '75%',
                         60 => '60%',
                         50 => '50&',
                    ),
                    'default_value' => 'default',
                    'return_format' => 'value',
                    'allow_null' => 0,
                    'layout' => 'horizontal',
               ),
          ),
          'location' => array(
               array(
                    array(
                         'param' => 'block',
                         'operator' => '==',
                         'value' => 'acf/container',
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