<?php

trait Masteryl_Response_Methods
{
    public function write($text)
    {
        $this->data[$this->target] .= $text;
    }

    public function text($text = '')
    {
        header("Content-Type: text/plain");
        echo $text;
        exit;
    }

    public function html($html = '')
    {
        header('Content-Type:text/html');
        echo $html;
        exit;
    }

    public function js($data) {
        header('Content-Type: application/javascript');
        echo $data;
        exit;
    }

    public function view($view, $args = [], $ext = '.php', $get = false)
    {
      $path = !empty($args['view_path']) ? $args['view_path'] : MASTERYL_APP_PATH . $this->views_dir . '/';

      // $path = MASTERYL_APP_PATH . $this->views_dir . '/' . str_replace('.', '/', $view) . $ext;
      $path .= str_replace('.', '/', $view) . $ext;

        // echo $path;exit;
        $template = new Masteryl_Template($path);

        // ee($args);
        // masteryl_send_json([$view, $args]);exit;
        if (!empty($args)) {
            $template->assign($args);
        }

        if ($get) {
            return $template->get();
        }

        $template->show();
        exit;
    }

    /**
     * Defaults to 
     *
     * @param string $url, default redirects to home page
     * @param [type] $status
     * @param string $x_redirect_by
     * @return void
     */
    public function redirect($url = '', $status = null, $x_redirect_by = '')
    {
        if(empty($url)) {
            $url = $this->app->getRoute('');
        }

        if ($status) {
            $this->status_code = $status;
        } elseif (!isset($this->status_code)) {
            $this->status_code = 302;
        }

        if (!MASTERYL_IS_WP) {
            http_response_code($this->status_code);
            return header("Location: ".$url);
        }

        
        wp_redirect($url, $this->status_code, $x_redirect_by);
        exit;
    }

    public function status($n)
    {
        $this->status_code = $n;
        return $this;
    }

    public function jsonMessage($message)
    {
        masteryl_send_json(compact('message'), $this->status_code);
        exit;
    }
}
