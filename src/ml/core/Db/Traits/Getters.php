<?php

trait Masteryl_Db_Getters
{
    public function get_col($query)
    {
        if (!$this->connected) $this->connect();

        $values = [];

        if ($result = $this->conn->query($query)) {
            while ($row = $result->fetch_array()) {
                array_push($values, $row[0]);
            }

            $result->close();
        }

        return $values;
    }

    public function get_var($query)
    {
        if (!$this->connected) {
            $this->connect();
        }

        if ($result = $this->conn->query($query)) {
            $row = $result->fetch_array();
            $result->close();
        }

        if (isset($row) && count($row) > 0) {
            return $row[0];
        }

        return null;
    }

    public function get_row($query, $outputType = 'array', $offset = 0)
    {
        if (!$this->connected) {
            $this->connect();
        }

        $row = null;

        if ($result = $this->conn->query($query)) {
            $row = $result->fetch_object();
            $result->close();
        }

        return $row;
    }

    public function get_results($query, $outputType = 'array')
    {
        if (!$this->connected) {
            $this->connect();
        }

        $rows = [];

        if ($result = $this->conn->query($query)) {
            while ($row = $result->fetch_object()) {
                array_push($rows, $row);
            }

            $result->close();
        }

        return $rows;
    }
}
