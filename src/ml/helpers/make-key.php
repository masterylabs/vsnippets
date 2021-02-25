<?php
function masteryl_make_key($length, $prefix = '')
{
    if (!strlen($prefix) % 2 == 0) {
        $prefix .= rand(0, 9); // buffer
    }

    if ($prefix != '') {
        $length = $length - strlen($prefix);
    }

    return $prefix . bin2hex(random_bytes($length / 2));
}

function masteryl_make_secret_key($name = '', $length = 32, $prefix = 'sk')
{
    if ($name != '') {
        $name = '_' . $name;
    }
    return masteryl_make_key($length, $prefix . $name . '_');
}

function masteryl_make_public_key($name = '', $length = 32, $prefix = 'pk')
{
    if ($name != '') {
        $name = '_' . $name;
    }
    return masteryl_make_key($length, $prefix . $name . '_');
}