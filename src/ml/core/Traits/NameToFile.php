<?php

trait Masteryl_NameToFile
{
    public function nameToFile($name, $ext = '')
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name))) . $ext;
    }
}
