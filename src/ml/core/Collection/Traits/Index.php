<?php

trait Masteryl_Collection_Index
{

    public function index($req, $res)
    {
        return $this->_index($req, $res);
    }

    public function _index($req, $res)
    {
        $this->query_method = 'index';
        
        $this->req = $req;

        $model = $this->model($req, true);

        if(!$model) {
            return $res->notFound();
        }

        if ($model->isRow()) {
            return $res->data($model);
        }

        if(isset($req->view) && $req->view == 'list' && $this->allow_list_view) {
            $this->cols = $this->getListView($req);
        }

        else {
         
            if (!$this->no_headers) {
                if (isset($this->association)) {
                    $headers = $this->getAssociateTableHeaders();
                } else {
                    $headers = $this->getTableHeaders();
                }
                $headers = $this->parseHeaders($headers);
            }

            if (!empty($headers)) {
                $this->cols = $this->getColsFromHeaders($headers);
            }
        }

        /**
         * Query Append
         */
        if (method_exists($this, 'queryAppend')) {
            $model = $this->queryAppend($model);
        }
        if (method_exists($this, 'queryAppendIndex')) {
            $model = $this->queryAppendIndex($model);
        }

        if ($this->no_pagin) {
            $collection = [
                'data' => $model->get($this->cols),
            ];
        } else {
            $collection = $model->paginate()->get($this->cols);
        }

        if (!empty($collection['data'])) {
            $collection['data'] = $this->onCollection($collection['data']);
        }

        if (isset($headers)) {
            $collection['headers'] = $headers;
        }

        if (!$this->no_permissions) {
            $collection['permissions'] = $this->getPermissions();
        }
    
        return $res->json($collection);
    }
}
