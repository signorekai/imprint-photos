<?php
/**
* Create Logo Setting and Upload Control
*/
function add_customizer_settings($wpc) {
  $wpc->add_section( 'page_options', array(
    'title' => 'Page Options',
    'priority' => 30,
  ));

  $wpc->add_setting('seo_description');
  $wpc->add_control( new WP_Customize_Control($wpc, 'seo_description', array(
    'label' => 'Description',
    'section' => 'title_tagline',
    'settings' => 'seo_description',
    'type' => 'textarea',
  )));

  $wpc->add_setting('footer_text');
  $wpc->add_control( new WP_Customize_Control( $wpc, 'footer_text',
    array(
    'label' => 'Footer Text',
    'section' => 'page_options',
    'settings' => 'footer_text',
    'type' => 'textarea',
    ) ) 
  );

  $wpc->add_setting('footer_bg');
  $wpc->add_control( new WP_Customize_Upload_Control( $wpc, 'footer_bg',
    array(
    'label' => 'Footer Background Image',
    'section' => 'page_options',
    'settings' => 'footer_bg',
    ) ) 
  );
}


add_action('customize_register', 'add_customizer_settings');