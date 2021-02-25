<?php

trait Masteryl_Time_Getters
{
    private function getUnix($v)
    {
        if (is_numeric($v)) {
            return (int) $v;
        }

        return strtotime($v);
    }

    private function getSeconds($v)
    {
        if (is_numeric($v)) {
            return (int) $v;
        }

        // str format: 10m, 8h, 3d, 5w, 2m, 10y
        if (preg_match($this->mysql_preg, $v)) {
            return strtotime($v);
        }

        // str format: 10m, 8h, 3d, 5w, 2m, 10y
        if (preg_match('/([0-9]){1,3}([smhdwy])/', $v)) {
            return $this->strToNum($v);
        }

        return empty($v) ? 0 : (int) $v;

        // process string
    }
}
