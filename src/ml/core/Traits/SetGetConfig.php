<?php

trait Masteryl_SetGetConfig
{
    public function setConfig($config = [], $prop = '_config')
    {
        $this->{$prop} = array_merge($this->{$prop}, $config);
    }

    public function getConfig($key = '', $def = '', $parse = null, $prop = '_config')
    {
        if (is_array($key)) {
            $values = [];
            foreach ($key as $i) {
                $values[$i] = $this->_getValue($i, $def, $this->{$prop}, $parse);
            }
            return $values;
        }
        return $this->_getValue($key, $def, $this->{$prop}, $parse);
    }

    protected function _getValue($key, $def, $arr, $parse = null)
    {
        if (empty($key)) {
            $value = isset($arr) && $arr != '' ? $arr : $def;
        }

        if (strstr($key, '.') == false) {
            $value = isset($arr[$key]) && $arr[$key] != '' ? $arr[$key] : $def;
        } else {
            $val = $arr;

            $keys = explode('.', $key);

            foreach ($keys as $key) {
                if (!isset($val[$key])) {
                    $val = $def;
                    break;
                }
                $val = $val[$key];
            }

            $value = isset($val) ? $val : $def;
        }

        if ($parse && strpos($parse, 'explode') === 0) {
            $sep = substr($parse, -1) !== 'e' ? substr($parse, -1) : ',';
            $value = explode($sep, $value);
        }

        return $value;
    }
}
