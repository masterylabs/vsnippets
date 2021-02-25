<?php

trait Masteryl_Response_Headers
{
    public function header($key, $val)
    {
        header("{$key}:{$val}");
        return $this;
    }

    public function withHeaders($arr)
    {
        foreach ($arr as $key => $val) {
            header("{$key}:{$val}");
        }
        return $this;
    }
}
