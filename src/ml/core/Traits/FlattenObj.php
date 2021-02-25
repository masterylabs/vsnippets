<?php

trait Masteryl_FlattenObj
{
  public function flattenObj($item) {
        
    if(empty($item))
    return $item;

    foreach($item as $key => $val) {
        if(is_object($val)) {
            foreach($val as $k2 => $v2) {
                $k = "{$key}_${k2}";
                $item->{$k} = $v2;
            }
            unset($item->{$key});
        }
    }
    return $item;
}
}