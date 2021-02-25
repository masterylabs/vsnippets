<?php

class Masteryl_Module
{
    protected static $options = [];

    public static function setOptions($opt, $val = null)
    {
        if (empty($opt)) {
            return;
        }
        // is key val
        if (is_string($opt)) {
            return self::$options[$opt] = $val;
        }

        if (is_array($opt)) {
            self::$options = array_merge($opt, self::$options);
        }
    }
}
