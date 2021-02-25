<?php

if (class_exists('Masteryl_Middleware')) {
    return;
}

abstract class Masteryl_Middleware
{
    use Masteryl_SetGetConfig;
}
