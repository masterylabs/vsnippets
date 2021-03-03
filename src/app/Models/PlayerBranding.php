<?php 


class Masteryl_PlayerBranding extends Masteryl_MetaModel
{
  protected $meta_key = 'player_branding';

  protected $fields = [
    'active' => false,
    'dark' => false,
    'color' => '',
    'logo' => [
      'contain' => false,
      'round' => false,
      'src' => 'https://bit.ly/3kNh6QQ',
      'href' => '',
      'size' => 75,
      'position' => 'tl',
      'opacity' => 0.5,
    ],
    'centerPlayRounded' => '',
  ];


}