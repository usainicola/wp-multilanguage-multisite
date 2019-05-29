<?php

// ------------------------------------------------------------------
// Add all your sections, fields and settings during admin_init
// ------------------------------------------------------------------
//

function eg_settings_api_init() {
// Add the section to general settings so we can add our
// fields to it
  add_settings_section(
    'eg_setting_section',
    'Custom settings',
    'eg_setting_section_callback_function',
    'general'
  );

// Add the field with the names and function to use for our new
// settings, put it in our new section
  add_settings_field(
    'frontend_language',
    'Frontend Language',
    'eg_setting_callback_function',
    'general',
    'eg_setting_section'
  );

// Register our setting so that $_POST handling is done for us and
// our callback function just has to echo the <input>
  register_setting( 'general', 'frontend_language' );
} // eg_settings_api_init()

add_action( 'admin_init', 'eg_settings_api_init' );


// ------------------------------------------------------------------
// Settings section callback function
// ------------------------------------------------------------------
//
// This function is needed if we added a new section. This function 
// will be run at the start of our section
//

function eg_setting_section_callback_function() {
  // echo '<p>Intro text for our settings section</p>';
}

// ------------------------------------------------------------------
// Callback function for our example setting
// ------------------------------------------------------------------
//
// creates a checkbox true/false option. Other types are surely possible
//

function eg_setting_callback_function() {
  echo '<input name="frontend_language" id="frontend_language" type="text" value="'.get_option( 'frontend_language' ).'" class="regular-text" />';
}