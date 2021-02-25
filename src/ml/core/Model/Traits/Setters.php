<?php

trait Masteryl_Model_Setters
{
    /**
     * Public
     */

    /**
     * Protected
     */

    /**
     * Privates
     */

     // ADDED
    public function setUpdateCol($key, $value)
    {
      $value = maybe_serialize($value);
      $this->query_update_cols[$key] = $this->parseKeyValue($key, $value); 
    }


    private function setUpdateCols($update = false, $ret = false)
    {
        $cols = $this->fills;

        $this->query_update_cols = [];

        foreach ($this->fills as $i) {
            if (!isset($this->{$i})) {
                continue;
            }

            $value = maybe_serialize($this->{$i});

            // check if changed
            if (!isset($this->db_row_values[$i]) || $this->db_row_values[$i] != $value) {               
                $this->query_update_cols[$i] = $this->parseKeyValue($i, $value);     
            }
        }

        if ($update && !empty($this->query_update_cols)) {
            $this->queryUpdate();
        }

        if ($ret) {
            return $this;
        }
    }

    private function setQueryArgs($args)
    {
        if (is_numeric($args)) {
            $this->query_limit = $args;
        } elseif (!empty($args)) {
            $argsMatch = false;

            if (isset($args['limit'])) {
                $this->query_limit = $args['limit'];
                $argsMatch = true;
            }

            // must come after limit
            if (isset($args['page'])) {
                $this->query_offset = ($this->query_limit * (int) $args['page']) - $this->query_limit;
                $argsMatch = true;
            }

            if (isset($args['cols'])) {
                $this->addCols($args['cols']);
                $argsMatch = true;
            }

            if (!$argsMatch) {
                $this->addCols($argsMatch);
            }
        }
    }
}
