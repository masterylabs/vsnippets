<?php


class Masteryl_SampleController
{
    public function __invoke($req, $res) 
    {
      return $res->view('sample');
    }

    public function api($req, $res)
    {
      return $res->data([]);
    }
}