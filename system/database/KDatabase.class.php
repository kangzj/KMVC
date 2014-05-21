<?php

/**
 * A very simple database class based on PDO
 * 
 * @author Kangzj
 *
 */
class KDatabase {

    private $pdo = null;
    //query times counter
    public $query_count = 0;
    private $log = null;

    /**
     * constructor
     */
    public function __construct($config_name = 'default') {
        $config = AppConfig::$dbconfig [$config_name];
        $dsn = $config ['type'] . ':host=' . $config ['host'] . ';port=' . $config ['port'] . ';dbname=' . $config ['name'];
        $this->pdo = new PDO($dsn, $config ['user'], $config ['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$config['charset']}"));
        $this->log = KLog::getInstance();
    }

    /**
     * destructor which close the database connection
     */
    public function __destruct() {
        $this->close();
    }

    /**
     * close the database connection
     * 
     */
    public function close() {
        
    }

    /**
     * query function which throws exception when error occured.
     * if select query successfully excuted, it will return a database result object.
     * on other queries, it will return nothing.
     * 
     * @param string $sql
     */
    public function query($sql) {
        //return num of affected rows.
        if ($this->is_write_type($sql)) {
            return $this->simple_query($sql);
        }
        //the following is meant for reading type sql.
        $result_id = $this->pdo->query($sql);
        $this->query_count++;
        if ($this->is_write_type($sql) === true) {
            return;
        }
        if(!$result_id){
            return;
        }
        $result = new KDatabaseResult ();
        $result->result_array = $result_id->fetchAll(PDO::FETCH_ASSOC);
        $result->num_rows = $result_id->rowCount();
        return $result;
    }

    /**
     * get last inert id
     * 
     */
    public function insertId() {
        return $this->pdo->lastInsertId();
    }

    /**
     * simple query
     * 
     * @param string $sql
     * @return int num of affected rows
     */
    function simple_query($sql) {
        $this->query_count++;
        $this->log->d("sql: $sql");
        return $this->pdo->exec($sql);
    }

    /**
     * return true if the sql is write type, otherwise it will
     * return false.
     * 
     * @param string $sql
     */
    private function is_write_type($sql) {
        if (!preg_match('/^\s*"?(SET|INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|TRUNCATE|LOAD DATA|COPY|ALTER|GRANT|REVOKE|LOCK|UNLOCK)\s+/i', $sql)) {
            return false;
        }
        return true;
    }

    public function get($table, $column = array(), $where = array(), $order = array(), $limit = 0, $offset = 0) {
        if (empty($column)) {
            $column_str = '*';
        } else {
            $column_str = implode(',', $column);
        }
        if (empty($where)) {
            $where_str = '1=1';
        } else {
            $where_str = implode(' and ', $where);
        }
        if ($offset != 0) {
            $limit_str = "limit $limit,$offset";
        } else {
            $limit_str = '';
        }
        if(empty($order)){
            $order_str = '';
        }else{
            $order_str = 'order by ' . implode(', ', $order);
        }
        $sql = "select $column_str from $table where $where_str $order_str $limit_str";
        return $this->query($sql);
    }

    public function insert($table, $row) {
        if (!is_array($row)) {
            throw new KDatabaseException('a row must be an array.');
        }
        foreach ($row as $k => $v) {
            $ks[] = $k;
            $vs[] = $v;
        }
        $ks_str = implode("`,`", $ks);
        $vs_str = implode("','", $vs);
        $sql = "INSERT INTO {$table} (`$ks_str`) VALUES ('$vs_str')";
        $this->simple_query($sql);
    }

    public function insert_batch($table, $rows) {
        if (!is_array($rows) || !is_array($rows[0])) {
            throw new KDatabaseException('every row must be an array.');
        }
        foreach ($rows as $row) {
            $this->insert($table, $row);
        }
    }

}