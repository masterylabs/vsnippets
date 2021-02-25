<?php

class Masteryl_Db
{
    use Masteryl_Db_Getters,
        Masteryl_Db_Update,
        Masteryl_Db_Insert,
        Masteryl_Db_Delete,
        Masteryl_Db_Query;

    protected $conn; // connection

    protected $connected = false;

    private $host = 'localhost';

    private $port = 3306;

    private $name;

    private $username = "";

    private $password = '';

    private $charset = 'utf8mb4'; // creating tables

    private $collate = 'utf8mb4_unicode_520_ci';

    public function __construct($config = [])
    {

        foreach ($config as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function getCharset()
    {
        return $this->charset;
    }

    public function getTableCols($table)
    {
        if (!$this->connected) {
            $this->connect();
        }

        $cols = [];
        $res = mysqli_query($this->conn, "SHOW COLUMNS FROM {$table}");
        while ($row = $res->fetch_assoc()) {
            $cols[] = $row['Field'];
        }
        return $cols;
    }

    public function getTables()
    {
        if (!$this->connected) {
            $this->connect();
        }

        $list = [];
        $res = mysqli_query($this->conn, "SHOW TABLES");
        while ($cRow = mysqli_fetch_array($res)) {
            $list[] = $cRow[0];
        }
        return $list;
    }

    public function query($q)
    {
        if (!$this->connected) {
            $this->connect();
        }

        return $this->conn->real_query($q);
    }

    

    public function testConnection($close = true)
    {
        $link = mysqli_connect($this->host, $this->username, $this->password, $this->name);

        $value = $link ? true : false;

        if ($close) {
            mysqli_close($link);
        }

        return $value;
    }

    private function connect()
    {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->name);

        if ($conn->connect_errno) {
            echo "Unable to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
            return $this->connected = false;
        }

        $this->conn = $conn;

        $this->connected = true;
    }
}
