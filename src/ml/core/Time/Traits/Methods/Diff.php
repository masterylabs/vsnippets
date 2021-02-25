<?php

trait Masteryl_Time_Diff
{
    // rpimary time

    private $mysql_preg = '/[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}/';

    // public static function expired($t, $add = 0)
    // {
    //     return (new static )->_expired($t, $add);
    // }

    // public function _expired($t, $add = 0)
    // {

    //     $t = $this->getUnix($t);

    //     $add = $this->getSeconds($add);

    //     echo "$t, $add";
    //     // //
    //     // // echo $add;exit;

    //     // $expire = $this->_time + $add - $this->getNow();

    //     // echo $this->_time . ' ' . ($expire / 60) / 60;

    //     exit;
    // }

    // public function getNow($format = 'U', $add = 0)
    // {
    //     if (!empty($add)) {
    //         $add = $this->getSeconds($add);
    //     }
    //     return current_time('U') + $add;
    // }

    // public static function getDiff($a, $b)
    // {
    //     return (new static )->diff($a, $b);
    // }

    // public function diff($a = null, $b = null)
    // {

    //     $a = $this->getSeconds($a);
    //     $b = $this->getSeconds($b);
    //     echo "diff: {$a}, {$b}";exit;
    // }
}
