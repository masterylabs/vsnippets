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
      'size' => 75,
      'opacity' => 0.5,
      'src' => '',
      'href' => '',
      'position' => 'tl',
    ],
    'centerPlayRounded' => '',
  ];

  public function onSave()
  {
    $this->active = true;
  }
}