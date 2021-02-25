<?php

class Masteryl_Vue
{
        // version2
    public $debug = false;

    protected $div_id = 'app';
    
    protected $baseurl;
    
    protected $dir_path;

    protected $remove_from_head = [
        'charset',
        'viewport',
        'http-equiv',
        'title',
        'rel="icon"'
    ];

    protected $data;

    protected $debug_js = ['chunk-vendors', 'chunk-common', 'app'];


    public function __construct($file, $data = [], $ext = '.html')
    {
        if(defined('MASTERYL_VUE_DEBUG')) $this->debug = MASTERYL_VUE_DEBUG;
        $this->data = $data;

        $i = explode('/', $file);
        array_pop($i);
        $dir = implode('/', $i);

        $url = MASTERYL_PUBLIC_URL . '/' . $dir;
       
        $file = MASTERYL_PUBLIC_PATH . "{$file}{$ext}";

        if (!file_exists($file)) {
            exit("vue missing file: {$file}");
        }


        $this->baseurl = $url;

        $contents = file_get_contents($file);

        // fix links
        $contents = str_replace('="/', '="'.$url.'/', $contents);

        $this->contents = $contents;
    }

    public function getDivId()
    {
        preg_match('/(?<=div id=")[a-zA-Z0-9_-]+/', $this->contents, $m);
        return $m[0];
    }

    public function head($embed = false)
    {
        echo $this->getHead($embed);
    }

    public function body()
    {
        echo $this->getBody();
    }

    public function getHead($embed = false)
    {
        if($this->debug) return '';
        
        preg_match('/(?<=\<head\>)(.*)(?=\<\/head)/', $this->contents, $m);
        $head = trim($m[0]);

        if(!$embed) return $head;

        $valid = [];

        $rows = explode('<', $head);
        foreach($rows as $row) {
            $remove = false;
            foreach($this->remove_from_head as $i) {
                if(strstr($row, $i) == true) {
                    $remove = true; break;
                }
                if($remove) break;
            }
            if(!$remove) $valid[] = $row;
        }

        return implode('<', $valid);
    }

    public function getBody()
    {
        if($this->debug) {
            return $this->getBodyDebug();
        }

        preg_match('/(?<=\<body\>)(.*)(?=\<\/body)/', $this->contents, $m);
        $body = trim($m[0]);
        
        $rows = explode('<', $body);
        $scripts = [];

        foreach($rows as $row)
        if(in_array(strpos($row, 'script'), [0,1], true)) $scripts[] = $row;

        return $this->getDiv() . '<'.implode('<', $scripts);
    }

    public function getDiv()
    {
        $div = '<div id="'.$this->getDivId().'"';

        if(!empty($this->data)) 
        foreach($this->data as $key => $val) 
        $div .= ' data-' . $key . '="' . htmlspecialchars($val) . '"';

        $div .= '></div>';

        return $div;
    }

    private function getBodyDebug()
    {
        if(is_string($this->debug)) {
            $url = $this->debug;
        } elseif(is_numeric($this->debug)) {
            $url = 'http://localhost:'.$this->debug;
        } else {
            $url = 'http://localhost:8081';
        }


        $html = $this->getDiv();

        foreach($this->debug_js as $i) {
            $html .= '<script src="'.$url.'/js/'.$i.'.js"></script>';
        }
        return $html;
    }
}
