<?php

/**
 * based on database class, now we can make some
 * model.
 * 
 * @author Kangzengji
 * @date 2012-02-22
 */
abstract class KModel {

    protected $data = array();
    protected static $Database = null;
    //must set in clild class
    protected $table_name = null;
    protected $primary_key = null;

    //must impl in child class
    abstract public function setTableName();

    abstract public function setPrimaryKey();

    public function __construct() {
        self::$Database = new KDatabase ();
    }

    public function __set($key, $val) {
        $this->data [$key] = $val;
    }

    public function __get($key) {
        return $this->data [$key];
    }

    public function save() {
        $fields = array_keys($this->data);
        $vals = array_values($this->data);
        $fields_string = '`' . implode('`,`', $fields) . '`';
        $vals_string = '\'' . implode("','", $vals) . '\'';
        $sql = "insert into {$this->table_name} ($fields_string) values ($vals_string)";
        self::$Database->query($sql);
    }

    public function update() {
        $sets = '';
        foreach ($this->data as $key => $val) {
            if ($key != $this->primary_key) {
                $sets .= "`$key`='$val', ";
            } else {
                $primary_key_val = $val;
            }
        }
        //remove the suffix ','
        $sets = substr($sets, 0, - 2);
        $sql = "update {$this->table_name} set $sets where {$this->primary_key}='$primary_key_val'";
        self::$Database->query($sql);
    }

    public function get() {
        $primary_key_val = $this->{$this->primary_key};
        $sql = "select * from {$this->table_name} where {$this->primary_key}={$primary_key_val} limit 1";
        $result = self::$Database->query($sql);
        if (!empty($result->result_array)) {
            $this->data = $result->result_array [0];
        }
    }

    public function delete() {
        $primary_key_val = $this->{$this->primary_key};
        $sql = "delete from {$this->table_name} where {$this->primary_key}={$primary_key_val} limit 1";
        self::$Database->query($sql);
    }

    public function clearData() {
        $this->data = null;
    }

}