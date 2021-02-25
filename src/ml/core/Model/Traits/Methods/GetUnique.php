<?php

trait Masteryl_Model_GetUnique
{

    /**
     * Slug tool
     */

    public static function getUnique($key, $value, $slugify = false, $sep = '-')
    {
        return (new static )->_getUnique($key, $value, $slugify, $sep);
    }

    public function _getUnique($key, $value, $slugify = false, $sep = '-')
    {
        if ($sep) {
            $value = str_replace(' ', $sep, $value);
        }

        if ($slugify) {
            $value = masteryl_slugify($value, $sep);
        }

        $result = $this->queryUnique($key, $value);

        if (!$result) {
            return $value;
        }

        $count = 2;

        while ($count <= $this->query_get_unique_max_count) {
            $check = $value . $sep . $count;

            $result = $this->queryUnique($key, $check);

            if (!$result) {
                return $check;
            }

            $count++;
        }

        return null;
    }
}
