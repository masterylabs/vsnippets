<?php

trait Masteryl_App_Router_Collection
{
    protected $is_processing_collection = false;

    public function collections($names, $args = null)
    {
        foreach ($names as $name) {
            $this->collection($name);
        }
    }

    private function getCollectionCb($name)
    {
        if (strstr($name, '-') == true) {
            $part = explode('-', $name);
            $name = implode('', array_map("ucfirst", $part));
        } else {
            $name = ucfirst($name);
        }
        return Masteryl_Inflector::singularize($name) . 'Collection@';
    }

    // $route, $cb, $args
    public function collection($name, $subs = null, $args = null)
    {
        $this->is_processing_collection = true;

        // list

        if (strstr($name, '/') == true) {
            $part = explode('/', $name);
            $cb = $this->getCollectionCb(end($part));

            $part[count($part) - 1] = Masteryl_Inflector::pluralize($part[count($part) - 1]);
            $route = implode('/', $part);
        } else {
            $route = Masteryl_Inflector::pluralize($name);
            $cb = $this->getCollectionCb($name);
        }

        $this->collectionRoutes($route, $cb, $args);

        // sub routes
        if ($subs) {
            if (!is_array($subs)) {
                $subs = [$subs];
            }

            foreach ($subs as $name) {
                $this->collectionRoutes($route . '/{id}/' . $name, $cb, $args, $name, $name);
            }
        }

        $this->is_processing_collection = false;
    }

    private function collectionRoutes($route, $cb, $args = null, $key = 'id', $append = false)
    {
        // ee('collectionRoutes', $args);

        // slug (must be above show)
        $m = $this->getCollectionMethod('slug', $append);
        $this->validateRoute('GET', $route . '/{' . $key . '}/slug', $cb . $m, $args);
        $this->validateRoute('GET', $route . '/slug', $cb . $m, $args);

        // list
        $m = $this->getCollectionMethod('index', $append);
        // echo $cb . $m;exit;
        $this->validateRoute('GET', $route, $cb . $m, $args);

        // create
        $m = $this->getCollectionMethod('create', $append);
        $this->validateRoute('POST', $route, $cb . $m, $args);

        // show item
        $m = $this->getCollectionMethod('show', $append);
        $this->validateRoute('GET', $route . '/{' . $key . '}', $cb . $m, $args);

        // item updates
        $m = $this->getCollectionMethod('update', $append);
        // echo $cb . $m . "\n"; //exit;
        $this->validateRoute('POST', $route . '/{' . $key . '}', $cb . $m, $args);
        $this->validateRoute('PUT', $route . '/{' . $key . '}', $cb . $m, $args);
        $this->validateRoute('PATCH', $route . '/{' . $key . '}', $cb . $m, $args);

        // delete item
        $m = $this->getCollectionMethod('destroy', $append);
        $this->validateRoute('DELETE', $route . '/{' . $key . '}', $cb . $m, $args);
        $this->validateRoute('POST', $route . '/{' . $key . '}/delete', $cb . $m, $args);

        // options
        $this->validateRoute('OPTIONS', $route, $cb, $args);
        $this->validateRoute('OPTIONS', $route . '/{' . $key . '}', $cb, $args);
    }

    private function getCollectionMethod($meth, $sub = false)
    {
        if (!$sub) {
            return $meth;
        }

        $meth = ucfirst($meth);

        return $sub . $meth;

        return $sub . ucfirst($meth);
    }
}
