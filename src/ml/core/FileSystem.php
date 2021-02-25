<?php

class Masteryl_FileSystem
{
    protected $basedir;
    
    protected $baseurl;

    private $empty_file = 'index.php';

    private $empty_file_contents = '<?php // ';


    public function __construct($appId = 'masteryl', $dir = false, $args = [])
    {

        if (MASTERYL_IS_WP) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();

            // create base dir
            $wpdir = wp_upload_dir();

            $this->basedir = $wpdir['basedir'] . '/' . $appId;
            $this->baseurl = $wpdir['baseurl'] . '/' . $appId;

        }

        else {
            $this->basedir = substr(MASTERYL_UPLOADS_PATH, 0, -1); // remove path forward slash
            $this->baseurl = masteryl_get_site_url($this->fallback_url);
        }

        if(!empty($args)) {
            foreach($args as $key => $val) 
            $this->{$key} = $val;
        }

        // create directory
        if (!file_exists($this->basedir)) {
            $this->mkdir();
            if (MASTERYL_IS_WP) {
                $this->createEmptyFile();
            }
        }

        if($dir) {
            $this->basedir .= '/'.$dir;
            $this->baseurl .= '/'.$dir;
            if (!file_exists($this->basedir)) {
                $this->mkdir();
            }
        }
    }

    public function getDir($dir = '')
    {

    }

    public function getJson($file, $false = null)
    {
        $data = $this->get($file);

        if(!empty($data)) {
            return json_decode($data);
        }

        return $false;
    }

    public function get($file, $false = false)
    {
        $path = $this->getFilePath($file);

        if(!file_exists($path)) return $false;

        return file_get_contents($path);
    }

    private function getFilePath($file) {
        return $this->basedir . '/' . ltrim($file, '/');
    }

    public function create($file, $content = '')
    {
        return $this->put($file, $content);
    }

    public function put($file, $contents = '') {
        $file = ltrim($file, '/');

        $this->createFilePath($file);

        $this->_createFile($file, $contents);
    }



    public function mkdir($dir = '') {

        // ee('mkdir', $dir);

        if(strstr($dir, '/') == false) {
            $dirs = [$dir];
        }
        else {
            $dirs = explode('/', $dir);
        }

        $dir = $this->basedir;
        foreach($dirs as $i) {
            $dir .= '/'.$i;
            if(!file_exists($dir)) {
                if (MASTERYL_IS_WP) wp_mkdir_p($dir);
                 else mkdir($dir); 
            }
        }
    }

    private function createFilePath($file)
    {
        $file = ltrim($file, '/');
        if(strstr($file, '/') == true) {
            $a = explode('/',$file);
            array_pop($a);
            $dir = implode('/', $a);
            $this->mkdir($dir);
        }
    }

    private function _createFile($file = '', $contents = '')
    {
        
        $file = $this->basedir . '/' . ltrim($file, '/');

        
        if (!MASTERYL_IS_WP) return file_put_contents($file, $contents);
      
        global $wp_filesystem;

        $perm = defined('FS_CHMOD_FILE') ? FS_CHMOD_FILE : 0644;

        $wp_filesystem->put_contents(
            $file,
            $contents,
            $perm // predefined mode settings for WP files
        );
    }

    private function createEmptyFile($path = '')
    {
        $file = rtrim($path, '/') . '/' . ltrim($this->empty_file, '/');
        $this->_createFile($file, $this->empty_file_contents);        
    }
}



