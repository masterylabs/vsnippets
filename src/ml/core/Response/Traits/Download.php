<?php

trait Masteryl_Response_Download
{
  public function download($download, $false = false, $exit = true)
  {
    if(!is_object($download) && is_array($download))
    $download = json_decode(json_encode($download));

    $file = $download->file_path;

    if (!file_exists($file)) {
        return $false;
    }
    
    header('Content-Description: File Transfer');
    header("Content-Type: {$download->file_type}");
    header('Content-Disposition: attachment; filename="' . $download->file_name . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);

    if($exit) {
      exit;
    }

  }
}