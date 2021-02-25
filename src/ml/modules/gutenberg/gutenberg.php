<?php

if(!function_exists('register_block_type')) return;

function masteryl_gutenberg_get_url($ext)
{
  return MASTERYL_PUBLIC_URL . '/gutenberg/' . ltrim($ext, '/');
}

function masteryl_gutenberg_register_block_type($block, $options = [])
{
  register_block_type('masteryl-blocks/' . $block, 
  array_merge([
    'editor_script' => 'masteryl-gutenberg-editor-script',
    'editor_style' => 'masteryl-gutenberg-editor-style',
    'style' => 'masteryl-gutenberg-app-style'
  ], $options));
}


add_action('init', function() use($app) {

  $editorJsUrl = masteryl_gutenberg_get_url('editor.js');
  if(!empty($app->custom_gutenberg_editor_js)) $editorJsUrl = $app->custom_gutenberg_editor_js;

  wp_register_script(
    'masteryl-gutenberg-editor-script', 
    $editorJsUrl,
    [
      'wp-editor',
     'wp-blocks', 
     'wp-i18n', 
     'wp-element', 
     'wp-components',
     ]
  );

  wp_register_style(
    'masteryl-gutenberg-editor-style',
    masteryl_gutenberg_get_url('editor.css'),
    ['wp-edit-blocks']
  );

  wp_register_style(
    'masteryl-gutenberg-app-style',
    masteryl_gutenberg_get_url('app.css')
  );

  
  masteryl_gutenberg_register_block_type('image-drop');

});