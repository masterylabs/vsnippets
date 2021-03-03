<?php 


class Masteryl_TestModel extends Masteryl_MetaModel
{
  protected $meta_key = 'test';


  // protected $fields = [
  //   'active' => false,
  //   'dark' => false,
  //   'logoTile' => false,
  //   'color' => '',
  //   'logoSrc' => '',
  //   'logoHref' => '',
  //   'logoSize' => '',
  //   'logoPosition' => '',
  //   'logoOpacity' => '',
  //   'centerPlayRounded' => '',
  // ];

  protected $fields = [
    'active' => false,
    'dark' => false,
    'color' => '',
    'logo' => [
      'tile' => false,
      'src' => 'https://bit.ly/3kNh6QQ',
      'href' => '',
      'size' => 75,
      'position' => 'tl',
      'opacity' => 0.5,
    ],
    'centerPlayRounded' => '',
  ];


}