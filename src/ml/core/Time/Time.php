<?php

class Masteryl_Time
{
    use Masteryl_Time_Getters, Masteryl_Time_Diff, Masteryl_StrToNum;

    private $_time = null;

    public function __construct($time = null)
    {
        if (!$time) {
            $_time = current_time('U');
        } else {
            $this->set($time);
        }

        // echo $this->_time;exit;
    }

    public static function getElapsedMinutes($t)
    {
        return self::getElapsed($t, 'i');
    }

    public static function getElapsed($t, $u = 'i')
    {
        $dt = new DateTime($t); // Date post was created
        $dt2 = new DateTime(); // Default DateTime is now
        $val = $dt->diff($dt2);
        return $val->format('%' . $u);
        // echo $interval->format('Post created %i mins ago');
    }

    public function set($time)
    {
        $this->_time = $this->getUnix($time);
    }

    public function add($time = 0)
    {
        $this->_time = $this->_time + $this->getSeconds($time);
    }

    public function getCurrentTime($format = 'U')
    {
        return current_time($format);
    }

    public function elapsed()
    {
        return $this->getCurrentTime() - $this->_time;
    }
}
