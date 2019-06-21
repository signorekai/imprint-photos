<?php
/**
* Create Logo Setting and Upload Control
*/
function add_customizer_settings($wp_customize) {
  $wp_customize->add_section( 'page_options', array(
    'title' => 'Page Options',
    'priority' => 30,
  ));

  $wp_customize->add_setting('footer_text');
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_text',
    array(
    'label' => 'Footer Text',
    'section' => 'page_options',
    'settings' => 'footer_text',
    'type' => 'textarea',
    ) ) 
  );

  $wp_customize->add_setting('footer_bg');
  $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'footer_bg',
    array(
    'label' => 'Footer Background Image',
    'section' => 'page_options',
    'settings' => 'footer_bg',
    ) ) 
  );
}


add_action('customize_register', 'add_customizer_settings');