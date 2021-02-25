<?php


class Masteryl_Model
{
    use Masteryl_MakeKey, 
    Masteryl_Model_Attach,
    Masteryl_Model_BelongsTo,
    Masteryl_Model_BelongsToMany,
    Masteryl_Model_HasMany,
    Masteryl_Model_HasOne,
    Masteryl_Model_PivotOrder,
    // Masteryl_Model_BeforeCreate,
    Masteryl_Model_QueryError,
    Masteryl_Model_All,
    Masteryl_Model_Count,
    Masteryl_Model_Create,
    Masteryl_Model_Destroy,
    Masteryl_Model_Filters,
    Masteryl_Model_Find,
    Masteryl_Model_FindOrCreate,
    Masteryl_Model_CreateOrUpdate,
    Masteryl_Model_First,
    Masteryl_Model_GetUnique,
    Masteryl_Model_ItemFormat,
    Masteryl_Model_LeftJoin,
    Masteryl_Model_Paginate,
    Masteryl_Model_Req,
    Masteryl_Model_Save,
    Masteryl_Model_Search,
    Masteryl_Model_Update,
    Masteryl_Model_Where,

    // query
    // Masteryl_Model_QueryBeforeRequest,
    Masteryl_Model_QueryBuilders,
    Masteryl_Model_QueryCol,
    Masteryl_Model_QueryCollection,
    Masteryl_Model_QueryCount,
    Masteryl_Model_QueryCreate,
    Masteryl_Model_QueryDelete,
    Masteryl_Model_QueryRow,
    Masteryl_Model_QueryUnique,
    Masteryl_Model_QueryUpdate,
    Masteryl_Model_QueryWith,

    Masteryl_Model_Adders,
    Masteryl_Model_Getters,
    Masteryl_Model_Helpers,
    Masteryl_Model_Setters;   
    

    /**
     * Editables
     */

    protected $table;

    protected $cols;

    protected $fills = [];

    protected $headers = [];

    protected $hidden = [];

    protected $bool_cols = [];

    protected $int_cols = []; // 'id'

    protected $search_cols = ['name'];

    protected $default_cols;

    protected $error;

    protected $timestamps = true;

    /**
     * Options
     */

    protected $primary_key = 'id';

    protected $identifier_prefix;

    protected $pivot_timestamps = true;

    protected $query_page = 1;

    protected $query_limit = 0;

    protected $query_limit_max = 1000;

    protected $query_allow_ids_list = true;

    /**
     * Programmables
     */

    // protected static $_app_id;

    protected $table_prefix;

    private $app_prefix; // set in contructor

    private $custom_db;

    private $db_table;

    private $query_row = false;

    private $query_collection = false;

    private $query_cols = [];

    private $query_wheres = [];

    private $query_update_cols = [];

    private $inner_joins = [];

    private $left_joins = [];

    private $query_paginate;

    private $query_paginate_default_limit = 25;

    private $query_offset = 0;

    protected $query_order = ['id', 'ASC'];

    protected $json_cols = [];

    protected $query_children = true;

    // private $query_column_offset = 0;

    // private $query_row_offset = 0;

    private $query_output_type = 'OBJECT'; // ARRAY_A, ARRAY_N

    private $db_row_values; // stored object

    private $hidden_id;

    private $pivot_table;

    private $foreign_key;

    private $foreign_value;

    private $local_key;

    private $_last_query;

    private $query_filters = ['product', 'addon', 'tag'];

    private $query_not_in = []; // must not include filter

    private $query_in = []; // must include id

    private $query_filter_match_any = false;

    private $query_get_unique_max_count = 100;

    private $query_has_many;

    private $query_belongs_to; // not being used yet

    private $query_belongs_to_many;

    private $query_has_one;

    private $query_is_row = false;

    private $query_is_collection = false;

    protected $associations_type;

    protected $query_association_id; // could be private

    // protected $query_association;
    // private $foreign_id;

    protected $was_created = false;

    // added 
    protected $_timestamps_format = 'mysql';

    protected $database;

    private $_database;

    // added 11.2.21
    
    protected $unique_cols; // []
    
    // protected $use_schedule_automator = false;

    // protected $check_unique_cols_on_create = false;

    // protected $check_unique_cols_on_update = false;


    public function __construct()
    {
        global $masteryl_app;

        if(isset($this->database)) {
            $this->_database = $masteryl_app->selectDatabse($this->database);
        }
        
        // app_id is added in setup (bootsrap)
        elseif (!isset($this->table_prefix)) {
            $this->table_prefix = Masteryl_App::getTablePrefix();
        }



        // set cols

        if (!empty($this->cols)) {
            foreach ($this->cols as $key => $value) {

                // set fills (could be default)

                if (isset($value['fillable'])) {
                    array_push($this->fills, $key);
                }

                // headers

                if (isset($value['header'])) {
                    array_push($this->headers, [
                        'text' => isset($value['text']) ? $value['text'] : $key,
                        'value' => $this->keyToText($key),
                    ]);
                }

                if (isset($value['hidden'])) {
                    array_push($this->hidden, $key);
                }

                if (isset($value['bool'])) {
                    array_push($this->bool_cols, $key);
                }

                if (isset($value['int'])) {
                    array_push($this->int_cols, $key);
                }
            }
        }

        // set db_table

        $this->db_table = $this->getTable();
    }


    public function getTable($table = null, $customPrefix = false)
    {

        if (!$table) {
            $table = $this->table;
        }

        if($customPrefix) return $customPrefix . $table;

        if(!empty($this->table_prefix)) return $this->table_prefix . $table;

        return $table;
    }


    public function getProp($key)
    {
        return $this->{$key};
    }


    public function setProp($key, $value)
    {
        $this->{$key} = $value;
    }

    // temp

    private function db()
    {
        if(isset($this->_database)) return $this->_database;
        
        global $wpdb;

        if (!empty($wpdb)) {
            return $wpdb;
        }
       
        return $app->db();
    }


    // public function with($associations, $args = null)
    // {
    // }

    public function __call($name, $args = [])
    {
        // echo $name."\n";
        if (method_exists($this, $name)) {
            return;
        }

        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $name, $w);
        $w = $w[0];

        $key = 'query_' . array_shift($w);

        if(empty($w)) return;

        $w[0] = lcfirst($w[0]);

        $value = implode('', $w);

        if (!isset($this->{$key})) {
            $this->{$key} = [];
        }

        $entry = [$value, $args];

        array_push($this->{$key}, $entry);

        // ee($entry, $args);

        return $this;
    }

    private $query_with;


    public function defaultValues($values = [])
    {
        // return null
        if(empty($this)) {
            return $this;
        }

        foreach($values as $key => $val) {
            if(!isset($this->{$key})) {
                $this->{$key} = $val;
            }
        }

        return $this;
    }

    public function loadFills()
    {
        foreach($this->fills as $i) {
            
            if(!isset($this->{$i})) 
            $this->{$i} = in_array($i, $this->bool_cols) ? false : (in_array($i, $this->int_cols) ? 0 : '');
            
        }

        return $this;
    }
}
