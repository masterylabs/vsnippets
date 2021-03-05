<?php 


class Masteryl_PromoAlert extends Masteryl_MetaModel
{
  protected $meta_key = 'promo_alert';

  protected $fields = [
    'active' => false,
    // 'dismissible' => true,
    'noClose' => false,
    'dense' => false,
    'useBtn' => false,
    'noIcon' => false,
    'content' => '',
    'alertType' => '',
    'href' => '',
    'btnText' => '',
    'btnColor' => '#F44336FF',
    'showTime' => 0,
  ];


}