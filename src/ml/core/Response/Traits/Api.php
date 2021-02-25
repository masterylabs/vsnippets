<?php

trait Masteryl_Response_Api
{
    public function ok($code = 200)
    {
        http_response_code($code);
        exit;
    }

    public function data($data, $code = 200)
    {
        masteryl_send_json(compact('data'), $code);
        exit;
    }

    public function notFound($message = 'Not found', $code = 404)
    {
        masteryl_send_json(compact('message'), $code);
        exit;
    }

    public function json($data = '')
    {
        masteryl_send_json($data, $this->status_code);
    }

    public function success($msg = [], $code = 200, $data = null)
    {
        if (is_string($msg)) {
            $msg = ['message' => $msg];
        }
        $msg['code'] = $code;

        if ($data) {
            $msg['data'] = $data;
        }

        masteryl_send_json($msg, $code);
        exit;
    }

    public function paymentRequired($msg = 'Payment required', $code = 402) 
    {
        return $this->error($msg, $code);
    }

    public function error($msg = [], $code = 400, $errors = null)
    {
        if (is_string($msg)) {
            $msg = ['message' => $msg];
        }
        $msg['code'] = $code;

        if ($errors) {
            $msg['errors'] = $errors;
        }

        masteryl_send_json($msg, $code);
        exit;
    }

    public function invalid($message = 'Invalid', $code = 422, $errors = null)
    {
        return $this->jsonError($message, $code, $errors);
    }

    public function noAuth($message = 'Unauthorized', $errors = null, $code = 403)
    {
        return $this->jsonError($message, $code, $errors);
    }

    public function jsonError($message, $code = 400, $errors = null)
    {
        $response = compact('message', 'code');

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        masteryl_send_json($response, $code);
        exit;
    }
}
