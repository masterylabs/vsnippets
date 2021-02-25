<?php
trait Masteryl_Template_Simple // NOT IN USE
{
   // version 2
   protected $_title = '';
   protected $_head = '';
   protected $_body = '';

   public function setTitle($title)
   {
    $this->_title = $title;
   }

   public function setHead($head)
   {
    $this->_head = $head;
   }

   public function setBody($body)
   {
    $this->_title = $body;
   }

   public function render($args = [])
   {
       if(!empty($args)) {
           foreach($args as $key => $val) {
               $key = "_{$key}";
               $this->{$key} = $val;
           }
       }

       
   }
}