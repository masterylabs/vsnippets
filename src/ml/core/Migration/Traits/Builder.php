<?php

trait Masteryl_Migration_Builder
{
    public function increments($col = 'id', $len = 9, $type = 'mediumint')
    {
        $this->cols[] = $col;

        $this->primary_key = $col;

        array_push($this->create_cols, "{$col} {$type}({$len}) NOT NULL AUTO_INCREMENT");

        return $this;
    }

    public function setDefault($value = '') 
    {
        if(is_string($value)) $value = "'{$value}'";
        $last = end($this->create_cols);
        $last .= " DEFAULT {$value}";
        $index = count($this->create_cols) - 1;
        $this->create_cols[$index] = $last;
        // ee($this->create_cols);
        return $this;
    }

    public function integer($col, $len = 11, $def = 0)
    {
        $this->cols[] = $col;

        if(gettype($def) == 'number') "{$col} INT({$len}) DEFAULT {$def} NOT NULL";
        else $this->create_cols[] = "{$col} INT({$len}) NOT NULL";

        
        return $this;
    }

    public function boolean($col, $def = 0)
    {
        $this->cols[] = $col;
        $this->create_cols[] = "{$col} TINYINT(1) DEFAULT {$def} NOT NULL";
        return $this;
    }

    public function identifier($col = 'identifier', $len = 32)
    {
      $this->cols[] = $col;
      $this->create_cols[] = "{$col} VARCHAR({$len}) UNIQUE NOT NULL";
      return $this;
    }

    // public function slug($col = 'slug', $len = 191)
    // {
    //   $this->cols[] = $col;
    //   $this->create_cols[] = "{$col} VARCHAR({$len}) UNIQUE NOT NULL";
    //   return $this;
    // }

    // can set default to false
    public function string($col, $len = 191, $def = '')
    {
        $this->cols[] = $col;

        if(gettype($def) == 'string') $this->create_cols[] = "{$col} VARCHAR({$len}) DEFAULT '{$def}' NOT NULL";
        else $this->create_cols[] = "{$col} VARCHAR({$len}) NOT NULL";
        
        return $this;
    }

    public function decimal($col, $a, $b)
    {
        $this->cols[] = $col;
        $this->create_cols[] = "{$col} DECIMAL({$a},{$b}) NOT NULL";
        return $this;
    }

    public function double($col, $a, $b)
    {
        $this->cols[] = $col;
        $this->create_cols[] = "{$col} DOUBLE({$a},{$b}) NOT NULL";
        return $this;
    }

    public function float($col, $a, $b)
    {
        $this->cols[] = $col;
        $this->create_cols[] = "{$col} FLOAT({$a},{$b}) NOT NULL";
        return $this;
    }

    public function text($col)
    {
        $this->cols[] = $col;
        $this->create_cols[] = "{$col} TEXT NOT NULL"; //  NOT NULL
        return $this;
    }

    public function mediumtext($col)
    {
        $this->cols[] = $col;
        $this->create_cols[] = "{$col} MEDIUMTEXT NOT NULL"; //  NOT NULL
        return $this;
    }

    public function longtext($col)
    {
        $this->cols[] = $col;
        $this->create_cols[] = "{$col} LONGTEXT NOT NULL"; //  NOT NULL
        return $this;
    }

    

    public function datetime($col)
    {
        $this->cols[] = $col;
        array_push($this->create_cols, "{$col} DATETIME NOT NULL");
        return $this;
    }

    public function timestamps()
    {
        return $this->datetime('created')->datetime('updated');
    }

    public function updated()
    {
        return $this->datetime('updated');
    }

    public function created()
    {
        return $this->datetime('created');
    }

    /**
     * Formatters
     */

    public function primaryKey($key)
    {
        $this->primary_key = $key;
        return $this;
    }

    public function primary()
    {
        $this->primary_key = end($this->cols);
        return $this;
    }

    public function unique()
    {
        $last = end($this->create_cols) . ' UNIQUE';
        $index = count($this->create_cols) - 1;
        $this->create_cols[$index] = $last;
        return $this;
    }

    /**
     * Not Sure
     */
    public function index()
    {
        $last = end($this->cols);
        $this->index_cols[] = $last;
        return $this;
    }

    public function unsigned()
    {
        $this->nullable();
        $last = end($this->create_cols) . ' UNSIGNED';
        $index = count($this->create_cols) - 1;
        $this->create_cols[$index] = $last;
        return $this;
        // return $this->nullable();
    }

    public function nullable()
    {
        $last = end($this->create_cols);
        $last = str_replace(' NOT NULL', '', $last);
        $index = count($this->create_cols) - 1;
        $this->create_cols[$index] = $last;
        return $this;
    }
}
