<?php


class Masteryl_WpAdminPage
{
    protected $app;

    protected $page_title = null; // = 'Page Title';

    protected $menu_title = null; //'Menu Title';

    protected $capability = 'edit_posts'; // install_plugins

    protected $menu_slug = null;

    protected $parent_slug = false;// 'upload.php';

    public $slug_append;

    public $title_append;

    protected $icon_url = '';

    protected $position = null;

    protected $use_wp_media = false;

    protected $is_window = false;

    protected $clear_wp_styles = false;

    protected $vue;

    protected $view;

    protected $auth;

    protected $customs = ['page_title', 'menu_title', 'menu_slug'];


    public function __construct($app, $options = [])
    {
        $this->app = $app;

        foreach($this->customs as $i) {
            $key = "custom_admin_page_{$i}";
            if(!empty($app->{$key})) {
                $this->{$i} = $app->{$key};
                // echo $i;
            }
        }
        // exit;


        if(!empty($options)) 
        foreach($options as $key => $val) $this->{$key} = $val;

        // ee($this);

        // ee($this->slug_append);


        if (!$this->page_title) {
            $this->page_title = $app->getConfig('app_name');
        }

        if (!$this->menu_title) {
            $this->menu_title = $this->page_title;
        }

        if(isset($this->title_append)) {
            $this->page_title .= $this->title_append;
            $this->menu_title .= $this->title_append;
        }



        if (!$this->menu_slug) {
            $url_prefix = $app->getConfig('url_prefix');
            $this->menu_slug = !empty($url_prefix) ? $url_prefix : $app->getConfig('app_id');
            // echo $this->menu_slug; exit;
        }

        // topbar_title

        if(isset($this->slug_append)) {
            $this->menu_slug .= $this->slug_append;
        }


        if($this->parent_slug || $this->is_window) {
            if($this->is_window) $this->parent_slug = null; // hide frm menu
            add_submenu_page(
                $this->parent_slug,
                $this->page_title,
                $this->menu_title,
                $this->capability,
                $this->menu_slug,
                [$this, '_body'],
                $this->position
            );
        } else {
            add_menu_page(
                $this->page_title,
                $this->menu_title,
                $this->capability,
                $this->menu_slug,
                [$this, '_body'],
                $this->icon_url,
                $this->position
            );
        }

        add_action('current_screen', function() {

            if(!current_user_can($this->capability)) return;

            $screen = get_current_screen();

            if(empty($screen) || !strstr($screen->id, '_page_'.$this->menu_slug, true)) return;
           
            $this->screen();

            add_action('admin_head', function() {

                $this->_head();

            });
            
        });
    }

    public function screen() 
    {
        // remove styles
        if (!empty($this->vue) || $this->clear_wp_styles) {
            wp_deregister_style('buttons');
            wp_enqueue_style('nav-menus');
            wp_enqueue_style('wp-pointer');
            wp_enqueue_style('widgets');
            wp_enqueue_style('site-icon');
            wp_enqueue_style('dashicons');
            wp_enqueue_style('admin-menu');
            wp_enqueue_style('common');
            wp_enqueue_style('dashboard');
            wp_enqueue_style('themes');
        }

        if ($this->use_wp_media) {
            wp_enqueue_media();
        }

        if($this->is_window) {
            $this->loadWindow();
        }
    }

    public function _head() {

        if(!empty($this->vue)) {

            $this->vue = $this->createVue();
            $this->vue->head(true);
        }

        if(method_exists($this, 'head')) $this->head();
    }

    public function _body()
    {
        if (!empty($this->vue)) {
            $this->vue->body();
        }

        if(!empty($this->view)) $this->loadView();
        
        // aditional hook in method
        if(method_exists($this, 'body')) $this->body();
    }

    private function loadWindow()
    {
        $vue = $this->createVue();

        $args = [
            'title' => $this->page_title,
            'head' => $vue->getHead(true),
            'body' => $vue->getBody()
        ];

        $res = new Masteryl_Response($this->app);
        $view = !empty($this->view) ? $this->view : 'window';
        $res->view($view, $args);
    }

    private function createVue() {
        
        $data = !empty($this->app->custom_admin_page_data) ? $this->app->custom_admin_page_data : [];

        $data['route'] =$this->app->base_route;        
        
        if(!empty($this->auth)) $data['token'] = $this->getAuthToken();

        return new Masteryl_Vue($this->vue, $data);
    }

    private function getAuthToken()
    {  
        $cl = 'Masteryl_'.Masteryl_Inflector::camelize($this->auth, '-');        
        $token = (new $cl($this->app))->getOrCreateToken();
        return $token['token'];
    }

    private function loadView()
    {
        $response = new Masteryl_Response($this->app);
        return $response->view($this->view);
    }


}