<?php


class Masteryl_Template
{
    use Masteryl_Template_ExtendLayout,
        Masteryl_Template_Loaders,
        Masteryl_Template_Methods;

    private $path;

    private $public_url;

    private $assignedAtts = [];

    private $_contents;

    private $layouts_regex = '/(@:extend\()[0-9a-zA-Z\s\.\/]*\)/';

    private $layout_tpl;


    public function __construct($file = '')
    {
        if(empty($file)) {
            return false;
        }

        if (!file_exists($file)) {
            exit('Error: Template file not found: ' . $file);
        }

        $this->path = dirname($file) . '/';

        // set public url
        $this->public_url = masteryl_get_app_url('/public');

        // Contents
        $this->_contents = file_get_contents($file);

        // partials
        $this->loadPartials($file);

        $this->_contents = $this->loadLayout($this->_contents);
    }
}
