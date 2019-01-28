<?php

function custom_theme_translation_metabox() {
  if (!is_multisite()) wp_die('Multisite not enabled. This plugin only works when multisite is active.');
  foreach (get_post_types() as $post_type) {
    add_meta_box(
      'language_select',
      'Select the translation for this content',
      'custom_theme_translation_metabox_callback',
      $post_type
    );
  }
}
add_action( 'add_meta_boxes', 'custom_theme_translation_metabox' );

function custom_theme_translation_metabox_callback($post) {
  wp_nonce_field( 'custom_theme_translation_metabox_nonce_name', 'custom_theme_translation_metabox_nonce' );
  $blogs = get_sites();
  foreach($blogs as $blog) {
    $path = strtoupper(str_replace('/', '', $blog -> path));
    $path = $path == '' ? 'EN' : $path;
    $existing_translation = get_post_meta( $post -> ID, 'translation_'.$path, true );
    if (get_current_blog_id()==$blog -> blog_id) continue;
    switch_to_blog( $blog -> blog_id );
    echo '<p>';
    echo '<label for="'.$path.'_translation">'.$path.' translation: ';
    echo '<select id="'.$path.'_translation" name="translation_'.$path.'">';
    echo '<option value="0">Select the "'.$path.'" translation for this content</option>';
    $contents = get_posts(array(
      'post_type' => get_post_types(),
      'posts_per_page' => -1,
    ));
    foreach ($contents as $content) {
      if (!$content -> post_title) continue;
      $selected = $existing_translation == $content -> ID ? 'selected' : '';
      echo '<option value="'.$content -> ID.'" '.$selected.'>'.$content -> post_title.'</option>';
    }
    echo '</select>';
    echo $existing_translation ? '<a href="'.get_edit_post_link($existing_translation).'">Edit</a>' : '';
    echo '</p>';
    restore_current_blog();
  }
}

function custom_theme_translation_metabox_save_function( $post_id ) {
  if ( !isset($_POST['custom_theme_translation_metabox_nonce']) ) return;
  if ( !wp_verify_nonce( $_POST['custom_theme_translation_metabox_nonce'], 'custom_theme_translation_metabox_nonce_name' ) ) return;
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  if ( !current_user_can( 'edit_post', $post_id ) ) return;
  if ( is_multisite() && ms_is_switched() ) return $post_id;
  $blogs = get_sites();
  foreach($blogs as $blog) {
    if (get_current_blog_id()==$blog -> blog_id) continue;
    $path = strtoupper(str_replace('/', '', $blog -> path));
    $path = $path == '' ? 'EN' : $path;
    $translation_id = isset($_POST['translation_'.$path]) ? (int) $_POST['translation_'.$path] : 0;
    update_post_meta( $post_id, 'translation_'.$path, $translation_id );
  }
}
add_action( 'save_post', 'custom_theme_translation_metabox_save_function' );
