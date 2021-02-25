<?php

class Masteryl_ContactCollection extends Masteryl_Collection
{
  protected function getModel()
  {
    // sleep(1);
    return new Masteryl_Contact;
  }

  public function getListView($req)
  {
      return [
          "id as value",
          "email as text",
          "first_name",
          "last_name"
      ];
  }
}