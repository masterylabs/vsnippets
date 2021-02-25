<?php

function masteryl_remote_get_json($url, $args = [])
{
    return masteryl_remote_request_json('GET', $url, $args);
}

function masteryl_remote_post_json($url, $args = [])
{
    return masteryl_remote_request_json('POST', $url, $args);
}

function masteryl_remote_post($url, $args = [])
{
    return masteryl_remote_request('POST', $url, $args);
}

function masteryl_remote_get($url, $args = [])
{
    return masteryl_remote_request('GET', $url, $args);
}

function masteryl_remote_request_json($method = 'GET', $url, $args = [])
{
    $args['json'] = true;

    if (empty($args['headers'])) {
        $args['headers'] = [];
    }
    $args['headers']['Accept'] = 'application/json';

    return masteryl_remote_request($method, $url, $args);
}

function masteryl_remote_request($method, $url, $args = [])
{

    $headers = [];

    if (!empty($args['headers'])) {
        foreach ($args['headers'] as $key => $value) {
            array_push($headers, "{$key}: {$value}");
        }
    }

    // ee('url', $url);

    $ch = curl_init($url);

    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    if ($method === 'POST') {

        $fields = [];
        $str = '';

        if (!empty($args['body'])) {
            foreach ($args['body'] as $key => $val) {
                $str .= $key . '=' . $val . '&';
            }
            $str = rtrim($str, '&');

        }

        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str);

    } else {
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $body = curl_exec($ch);
    curl_close($ch);

    // exit;

    if (!empty($args['json'])) {
        return json_decode($body);
    }
    return $body;

}