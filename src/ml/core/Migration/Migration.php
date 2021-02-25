<?php


class Masteryl_Migration
{
    use Masteryl_Migration_CreateOrUpdate,
    Masteryl_Migration_Builder,
        Masteryl_Migration_Helpers;

    protected $table; // set by migrate

    protected $primary_key;

    private $_db;

    protected $database;

    protected $table_prefix;

    protected $_app;

    public function __construct($app)
    {
        // ee('table', $this->table);
        // $this->_app = $app;
        // ee($app);
        

        if(isset($this->database)) {
            $this->_db = $app->selectDatabse($this->database);
        }

        else {
            // global $wbpdb;
            $this->_db = $app->db();
            
            if (!isset($this->table_prefix))
           $this->table_prefix = Masteryl_App::getTablePrefix();
            
        }

        if(!empty($this->table_prefix)) $this->table = $this->table_prefix . $this->table;


        // ee('table_previx', $this->table);
        
        // app_id is added in setup (bootsrap)
        
    }

    public static function createOrUpdate($name, $app)
    {
        $m = new $name($app);
        
        if (!$m->tableExists()) return $m->createTable();

        $m->updateTable();

    }

    // 

    public static function createOrUpdateDir($path, $app) 
    {
        if(!file_exists($path)) return;
        
        $files = masteryl_get_files($path);

        if(empty($files)) return;

        foreach($files as $file) {
            
            // include file
            require_once $file;

            // create a new migration
            $name = 'Masteryl_'.masteryl_get_name_from_path($file);

            // ee($name, class_exists($name));

            if(class_exists($name))
            $name::createOrUpdate($name, $app);

        }
    }
}
