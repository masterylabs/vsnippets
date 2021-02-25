<?php

trait Masteryl_Collection_Slug
{
    public function slug($req, $res)
    {
        return $this->_slug($req, $res);
    }

    

    public function _slug($req, $res)
    {
        $sep = !empty($req->sep) ? $req->sep : '-';

        $field = !empty($req->field) ? $req->field : 'slug';

        $text = $req->{$field};

        $id = !empty($req->id) ? $req->id : false;

        $slug = $this->getSlug($id, $text, $field, $sep);

        return $res->data($slug);
    }

    public function getSlug($id = false, $text = 'my-slug', $field = 'slug', $sep = '-') 
    {
        $slug = masteryl_slugify($text, $sep);

        $query = $this->getModel()->_where($field, $slug);

        if ($id) {
            $query->andWhere('id', '!=', $id);
        }

        $exists = $query->first(['id']);

        if ($exists) {
            $slug = $this->getUniqueSlug($slug, $field, $sep, $id);
        }

        return $slug;
    }

    private function getUniqueSlug($slug, $field, $sep, $id, $count = 2)
    {
        $checkSlug = $slug . $sep . $count;

        $query = $this->getModel()->_where($field, $checkSlug);

        if ($id) {
            $query->andWhere('id', '!=', $id);
        }

        $exists = $query->first(['id']);

        if ($exists) {
            $count++;
            return $this->getUniqueSlug($slug, $field, $sep, $id, $count);
        }

        return $checkSlug;
    }
}
