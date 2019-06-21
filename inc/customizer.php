<?php
function add_customizer_settings($wpc) {

  /**
   * Add "SEO" section
   */

  $wpc->add_section( 'seo', array(
    'title' => __('SEO Settings', 'winterfell'),
    'priority' => 35,
  ));

  $wpc->add_setting('seo_description');
  $wpc->add_control( new WP_Customize_Control($wpc, 'seo_description', array(
    'label' => __('Description', 'winterfell'),
    'section' => 'seo',
    'settings' => 'seo_description',
    'type' => 'textarea',
  )));

  $wpc->add_setting('seo_photo');
  $wpc->add_control( new WP_Customize_Upload_Control( $wpc, 'seo_photo',
    array(
    'label' => __('Cover Image', 'winterfell'),
    'description' => __('Select the cover image that will be displayed when shared on social media', 'winterfell'),
    'section' => 'seo',
    'settings' => 'seo_photo',
    ) ) 
  );

  /*
   * Add "Page Options" section to control page design settings
   */

  $wpc->add_section( 'page_options', array(
    'title' => __('Page Options', 'winterfell'),
    'priority' => 30,
  ));

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