<?php

/**
 * Request search
 */

trait Masteryl_Model_Req
{
    public static function req($req, $allowCols = false)
    {
        return (new static )->_req($req, $allowCols);
    }

    public function _req($req, $allowCols = false)
    {
        if ($allowCols && !empty($req->cols)) {
            $this->addCols(explode(',', $req->cols));
        }

        if (!empty($req->order)) {
            $this->query_order[1] = strtoupper($req->order);
        }
        if (!empty($req->orderby)) {
            $this->query_order[0] = $req->orderby;
        }

        if (!empty($req->limit)) {
            $this->take($req->limit);
        }

        if (!empty($req->page)) {
            $this->query_page = (int) $req->page;
        }

        if (!empty($req->offset)) {
            // $this->offset($req->offset);
            $this->query_offset = (int) $req->offset;
        }

        if (!empty($req->q)) {
            $this->search($req->q);
        }

        // filter without
        if (!empty($req->fwo)) {
            $this->filterWithoutStr($req->fwo);
        }
        if (!empty($req->fwithout)) {
            $this->filterWithoutStr($req->fwithout);
        }

        if (!empty($req->fmatch)) {
            $this->filterMatch($req->fmatch);
            // $this->query_filter_match_any = strtolower($req->fmatch) === 'any';
        }

        // filter with
        if (!empty($req->fwi)) {
            $this->filterWithStr($req->fwi);
        }

        // filter with
        if (!empty($req->fwith)) {
            $this->filterWithStr($req->fwith);
        }

        if ($this->query_allow_ids_list && !empty($req->ids)) {
            $ids = explode(',', $req->ids);

            if (empty($this->query_in)) {
                $this->query_in = $ids;
               
            } else {
                foreach ($ids as $i) {
                    if (!in_array($i, $ids, true)) {
                        array_push($this->query_in, $i);
                    }
                }
            }
        }

        // build request
        return $this;
    }

}
