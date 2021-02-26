<?php


class Masteryl_Video extends Masteryl_Model
{
  protected $table = 'videos';

  protected $fills = [
    'identifier',
    'name',
    'description',
    'image',
    'content',
  ];
}