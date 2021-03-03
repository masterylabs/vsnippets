<?php 


class Masteryl_PauseBanner extends Masteryl_MetaModel
{
  protected $meta_key = 'pause_banner';

  protected $fields = [
    'active' => false,
    'nobg' => false,
    'poster' => false,
    'contain' => false,
    'src' => '',
    'href' => ''
  ];


}