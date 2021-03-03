<?php 


class Masteryl_EndPoster extends Masteryl_MetaModel
{
  protected $meta_key = 'end_poster';

  protected $fields = [
    'active' => false,
    'nobg' => false,
    'poster' => false,
    'contain' => false,
    'noControls' => false,
    'src' => '',
    'href' => ''
  ];

}