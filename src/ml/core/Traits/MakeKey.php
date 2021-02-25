<?php

trait Masteryl_MakeKey
{
    protected function makeKey($length = 32, $prefix = '')
    {
        if (!strlen($prefix) % 2 == 0) {
            $prefix .= rand(0, 9); // buffer
        }

        if ($prefix != '') {
            $length = $length - strlen($prefix);
        }

        return $prefix . bin2hex(random_bytes($length / 2));
    }

    protected function makeSecretKey($name = '', $length = 32, $prefix = 'sk')
    {
        if ($name != '') {
            $name = '_' . $name;
        }
        return $this->makeKey($length, $prefix . $name . '_');
    }

    protected function makePublicKey($name = '', $length = 32, $prefix = 'pk')
    {
        if ($name != '') {
            $name = '_' . $name;
        }
        return $this->makeKey($length, $prefix . $name . '_');
    }
}

