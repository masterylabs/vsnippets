<?php

trait Masteryl_StrToNum
{
    // 10m, 3w  $str = '10mon';
    public function strToNum($str, $append = false)
    {
        // ee('strToNum',$str);
        if (is_numeric($str)) {
            return (int) $str;
        }

        $options = [
            's' => 1,
            'm' => 60,
            'min' => 60,
            'h' => 3600,
            'd' => 86400,
            'w' => 604800,
            'mon' => 2628000,
            'mo' => 2628000,
            'y' => 31536000,
        ];

        preg_match('/[smhdwy|mon]{1,3}/', $str, $unit);
        preg_match('/[0-9]{1,6}/', $str, $val);

        $unit = $unit[0];
        $val = (int) $val[0];

        $val = $options[$unit] * $val;

        if ($append) {
            $val += time();
        }

        return $val;
    }
}
