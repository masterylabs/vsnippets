<?php

// ?view=list&valueKey=identifier&textKey=title

trait Masteryl_Collection_ListView
{
  protected $allow_list_view = true;

  public function getListView($req)
  {
    $value = !empty($req->valueKey) ? $req->valueKey : 'id';
    $text = !empty($req->textKey) ? $req->textKey : 'name';

      return [
          "{$value} as value",
          "{$text} as text"
      ];
  }
}