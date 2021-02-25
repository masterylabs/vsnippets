<?php

class Masteryl_WpUploader
{

  public function upload($upload = false)
    {
      if(!$upload) {
        $upload = $_FILES['upload'];
      }
      
      $file = $upload['tmp_name'];
      $filename = $upload['name'];
      $parent_post_id = 0;

      $upload_file = wp_upload_bits($filename, null, file_get_contents($file));

      if (empty($upload_file['error'])) {
        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_parent' => $parent_post_id,
          'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
          'post_content' => '',
          'post_status' => 'inherit'
        );
        $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
        if (!is_wp_error($attachment_id)) {
          require_once(ABSPATH . "wp-admin" . '/includes/image.php');
          $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
          wp_update_attachment_metadata( $attachment_id,  $attachment_data );

          // wp_generate_attachment_metadata 
        }
      }
      
      return $upload_file;
    }
}