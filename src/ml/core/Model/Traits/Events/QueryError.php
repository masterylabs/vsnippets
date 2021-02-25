<?php

trait Masteryl_Model_QueryError
{
    protected function onQueryError($error = '', $message = '') // status
    {
        masteryl_send_json(['query_error' => $error, 'message' => $message]);
        exit;
    }
}
